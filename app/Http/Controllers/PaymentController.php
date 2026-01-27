<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\PaymentConfirmation;
use App\Mail\PaymentConfirmationMail;
use App\Mail\PurchaseKeysEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Stripe\Stripe;
use Stripe\Checkout\Session as StripeSession;

class PaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display checkout page
     */
    public function checkout()
    {
        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Tu carrito está vacío');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        return view('payments.checkout', compact('cartItems', 'total'));
    }

    /**
     * Process payment
     */
    public function processPayment(Request $request)
    {
        $request->validate([
            'card_number' => 'required|digits:16',
            'card_name' => 'required|string|max:255',
            'expiry_date' => 'required|regex:/^\d{2}\/\d{2}$/',
            'cvv' => 'required|digits:3',
        ]);

        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Tu carrito está vacío');
        }

        $total = $cartItems->sum(function ($item) {
            return $item->product->price * $item->quantity;
        });

        // Si el total supera los 100€, requiere confirmación por correo
        if ($total > 100) {
            // Crear token de confirmación
            $paymentConfirmation = PaymentConfirmation::create([
                'user_id' => auth()->id(),
                'token' => PaymentConfirmation::generateToken(),
                'amount' => $total,
                'expires_at' => Carbon::now()->addHours(24), // Expira en 24 horas
            ]);

            // Enviar correo de confirmación
            Mail::to(auth()->user()->email)->send(new PaymentConfirmationMail($paymentConfirmation));

            // Redirigir a página de pendiente
            return redirect()->route('payment.pending')
                ->with('info', 'Se ha enviado un correo de confirmación a ' . auth()->user()->email);
        }

        // Si es menor a 100€, procesar directamente
        $paymentSuccess = $this->simulatePayment($request->card_number);

        if ($paymentSuccess) {
            // Reducir el stock de cada producto
            foreach ($cartItems as $item) {
                $product = $item->product;
                $product->stock -= $item->quantity;
                $product->save();
            }

            // Vaciar el carrito
            CartItem::where('user_id', auth()->id())->delete();

            return redirect()->route('payment.success')
                ->with('success', 'Pago procesado correctamente');
        }

        return back()->with('error', 'Error al procesar el pago. Intenta nuevamente.');
    }

    /**
     * Simulate payment processing (fictitious)
     */
    private function simulatePayment($cardNumber)
    {
        // Simulación: si el número de tarjeta termina en número par, el pago es exitoso
        $lastDigit = (int) substr($cardNumber, -1);
        return $lastDigit % 2 === 0;
    }

    /**
     * Payment success page
     */
    public function success()
    {
        return view('payments.success');
    }

    /**
     * Payment pending confirmation page
     */
    public function pending()
    {
        return view('payments.pending');
    }

    /**
     * Confirm payment from email link
     */
    public function confirmPayment($token)
    {
        $paymentConfirmation = PaymentConfirmation::where('token', $token)->firstOrFail();

        // Verificar si ya fue confirmado
        if ($paymentConfirmation->confirmed) {
            return view('payments.already-confirmed');
        }

        // Verificar si expiró
        if ($paymentConfirmation->hasExpired()) {
            return redirect()->route('cart.index')
                ->with('error', 'El enlace de confirmación ha expirado. Por favor, intenta realizar la compra nuevamente');
        }

        // Mostrar página de confirmación con botón
        return view('payments.confirm', compact('paymentConfirmation'));
    }

    /**
     * Process confirmation from mobile
     */
    public function processConfirmation($token)
    {
        $paymentConfirmation = PaymentConfirmation::where('token', $token)->firstOrFail();

        // Verificar si ya fue confirmado
        if ($paymentConfirmation->confirmed) {
            return view('payments.already-confirmed');
        }

        // Verificar si expiró
        if ($paymentConfirmation->hasExpired()) {
            return redirect()->route('cart.index')
                ->with('error', 'El enlace de confirmación ha expirado');
        }

        // Obtener items del carrito del usuario
        $cartItems = CartItem::with('product')
            ->where('user_id', $paymentConfirmation->user_id)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Tu carrito está vacío');
        }

        // Reducir el stock de cada producto
        foreach ($cartItems as $item) {
            $product = $item->product;
            $product->stock -= $item->quantity;
            $product->save();
        }

        // Preparar datos para el correo de keys
        $purchaseData = [
            'orderId' => strtoupper(Str::random(8)),
            'userName' => auth()->user()->name,
            'total' => $paymentConfirmation->amount,
            'items' => []
        ];

        foreach ($cartItems as $item) {
            $purchaseData['items'][] = [
                'name' => $item->product->name,
                'quantity' => $item->quantity,
                'price' => $item->product->price,
                'key' => $this->generateKey($item->product->name)
            ];
        }

        // Enviar correo con las keys
        Mail::to(auth()->user()->email)->send(new PurchaseKeysEmail($purchaseData));

        // Vaciar el carrito
        CartItem::where('user_id', $paymentConfirmation->user_id)->delete();

        // Marcar como confirmado
        $paymentConfirmation->markAsConfirmed();

        return view('payments.mobile-success');
    }

    /**
     * Check payment status (AJAX endpoint)
     */
    public function checkStatus()
    {
        // Buscar la última confirmación del usuario (confirmada o pendiente)
        $paymentConfirmation = PaymentConfirmation::where('user_id', auth()->id())
            ->latest()
            ->first();

        if (!$paymentConfirmation) {
            return response()->json([
                'confirmed' => false
            ]);
        }

        // Si está confirmada y fue actualizada en los últimos 5 minutos, redirigir
        $recentlyConfirmed = $paymentConfirmation->confirmed && 
                            $paymentConfirmation->updated_at->diffInMinutes(now()) < 5;

        return response()->json([
            'confirmed' => $recentlyConfirmed
        ]);
    }

    /**
     * Create Stripe Checkout Session (Real implementation - commented)
     */
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        $lineItems = [];
        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $item->product->name,
                    ],
                    'unit_amount' => $item->product->price * 100, // Stripe uses cents
                ],
                'quantity' => $item->quantity,
            ];
        }

        try {
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
                'cancel_url' => route('cart.index'),
            ]);

            return redirect($session->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Error al crear la sesión de pago: ' . $e->getMessage());
        }
    }

    /**
     * Generate fictitious key for product
     */
    private function generateKey($productName)
    {
        // Generar una key ficticia basada en el formato típico de keys de juegos
        // Formato: XXXXX-XXXXX-XXXXX-XXXXX-XXXXX
        $segments = [];
        for ($i = 0; $i < 5; $i++) {
            $segments[] = strtoupper(Str::random(5));
        }
        return implode('-', $segments);
    }
}
