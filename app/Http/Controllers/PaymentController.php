<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\PaymentConfirmation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Mail\PaymentConfirmationMail;
use App\Mail\PurchaseKeysEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
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
            // Crear el pedido en la base de datos
            $order = $this->createOrder($cartItems, $total);

            // Enviar correo con las keys
            $this->sendPurchaseEmail($order);

            // Vaciar el carrito
            CartItem::where('user_id', auth()->id())->delete();

            return redirect()->route('payment.success')
                ->with('success', 'Pago procesado correctamente')
                ->with('order_id', $order->id);
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

        // Crear el pedido en la base de datos
        $order = $this->createOrder($cartItems, $paymentConfirmation->amount, $paymentConfirmation->user_id);

        // Enviar correo con las keys
        $this->sendPurchaseEmail($order);

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
        // Verificar si es un producto "Mystery Key"
        if (stripos($productName, 'mystery') !== false) {
            return $this->generateMysteryKey();
        }

        // Generar una key ficticia basada en el formato típico de keys de juegos
        // Formato: XXXXX-XXXXX-XXXXX-XXXXX-XXXXX
        $segments = [];
        for ($i = 0; $i < 5; $i++) {
            $segments[] = strtoupper(Str::random(5));
        }
        return implode('-', $segments);
    }

    /**
     * Generate Mystery Key - Random Steam game key
     */
    private function generateMysteryKey()
    {
        // Lista de juegos populares de Steam para Mystery Keys
        $mysteryGames = [
            'Cyberpunk 2077',
            'The Witcher 3: Wild Hunt',
            'Red Dead Redemption 2',
            'Elden Ring',
            'God of War',
            'Hogwarts Legacy',
            'Baldur\'s Gate 3',
            'Starfield',
            'Street Fighter 6',
            'Resident Evil 4 Remake',
            'Dead Space Remake',
            'Atomic Heart',
            'Hades',
            'Hollow Knight',
            'Stardew Valley',
            'Terraria',
            'Dead Cells',
            'Celeste',
            'Undertale',
            'Portal 2',
        ];

        // Seleccionar un juego aleatorio
        $randomGame = $mysteryGames[array_rand($mysteryGames)];

        // Generar key para ese juego
        $segments = [];
        for ($i = 0; $i < 5; $i++) {
            $segments[] = strtoupper(Str::random(5));
        }
        $key = implode('-', $segments);

        // Retornar con el nombre del juego revelado
        return $key . ' [' . $randomGame . ']';
    }

    /**
     * Create order in database
     */
    private function createOrder($cartItems, $total, $userId = null)
    {
        return DB::transaction(function () use ($cartItems, $total, $userId) {
            // Crear el pedido
            $order = Order::create([
                'user_id' => $userId ?? auth()->id(),
                'order_number' => Order::generateOrderNumber(),
                'total' => $total,
                'status' => 'completed',
            ]);

            // Crear los items del pedido
            foreach ($cartItems as $item) {
                $product = $item->product;

                // Reducir el stock
                $product->stock -= $item->quantity;
                $product->save();

                // Generar key para el producto
                $productKey = $this->generateKey($product->name);

                // Crear el item del pedido
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item->quantity,
                    'subtotal' => $product->price * $item->quantity,
                    'product_key' => $productKey,
                ]);
            }

            return $order;
        });
    }

    /**
     * Send purchase email with keys
     */
    private function sendPurchaseEmail($order)
    {
        $purchaseData = [
            'orderId' => $order->order_number,
            'userName' => $order->user->name,
            'total' => $order->total,
            'items' => []
        ];

        foreach ($order->items as $item) {
            $purchaseData['items'][] = [
                'name' => $item->product_name,
                'quantity' => $item->quantity,
                'price' => $item->price,
                'key' => $item->product_key
            ];
        }

        Mail::to($order->user->email)->send(new PurchaseKeysEmail($purchaseData));
    }
}
