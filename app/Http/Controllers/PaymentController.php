<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CartItem;
use App\Models\PaymentConfirmation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\DiscountCode;
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
            'discount_percentage' => 'nullable|integer|min:0|max:100',
            'validated_code' => 'nullable|string',
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

        // Aplicar descuento si existe
        $discountPercentage = 0;
        $discountCodeModel = null;
        
        if ($request->has('validated_code') && $request->validated_code) {
            $discountCodeModel = DiscountCode::where('code', $request->validated_code)
                ->where('user_id', auth()->id())
                ->first();
            
            if ($discountCodeModel && $discountCodeModel->isValid()) {
                $discountPercentage = $discountCodeModel->discount_percentage;
                $total = $total - ($total * ($discountPercentage / 100));
            }
        }

        // Requiere confirmación por correo siempre
        // Crear token de confirmación
        $paymentConfirmation = PaymentConfirmation::create([
            'user_id' => auth()->id(),
            'token' => PaymentConfirmation::generateToken(),
            'code' => PaymentConfirmation::generateCode(),
            'amount' => $total,
            'expires_at' => Carbon::now()->addHours(24), // Expira en 24 horas
        ]);

        // Guardar el código de descuento en sesión para usarlo después
        if ($discountCodeModel) {
            session(['pending_discount_code' => $discountCodeModel->id]);
        }

        // Enviar correo de confirmación
        Mail::to(auth()->user()->email)->send(new PaymentConfirmationMail($paymentConfirmation));

        // Redirigir a página para introducir código
        return redirect()->route('payment.enter-code')
            ->with('info', 'Se ha enviado un código de confirmación a ' . auth()->user()->email);
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
     * Show page to enter confirmation code
     */
    public function enterCode()
    {
        return view('payments.enter-code');
    }

    /**
     * Verify confirmation code
     */
    public function verifyCode(Request $request)
    {
        $request->validate([
            'code' => 'required|digits:6',
        ]);

        $paymentConfirmation = PaymentConfirmation::where('code', $request->code)
            ->where('user_id', auth()->id())
            ->first();

        if (!$paymentConfirmation) {
            return back()->withErrors(['code' => 'El código ingresado no es válido'])
                ->withInput();
        }

        // Verificar si ya fue confirmado
        if ($paymentConfirmation->confirmed) {
            return view('payments.already-confirmed');
        }

        // Verificar si expiró
        if ($paymentConfirmation->hasExpired()) {
            return redirect()->route('cart.index')
                ->with('error', 'El código de confirmación ha expirado. Por favor, intenta realizar la compra nuevamente');
        }

        // Obtener items del carrito del usuario
        $cartItems = CartItem::with('product')
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')
                ->with('error', 'Tu carrito está vacío');
        }

        // Crear el pedido en la base de datos
        $order = $this->createOrder($cartItems, $paymentConfirmation->amount);

        // Enviar correo con las keys
        $this->sendPurchaseEmail($order);

        // Vaciar el carrito
        CartItem::where('user_id', auth()->id())->delete();

        // Marcar como confirmado
        $paymentConfirmation->markAsConfirmed();

        // Marcar el código de descuento como usado si existe
        if (session()->has('pending_discount_code')) {
            $discountCode = DiscountCode::find(session('pending_discount_code'));
            if ($discountCode) {
                $discountCode->markAsUsed();
            }
            session()->forget('pending_discount_code');
        }

        return redirect()->route('payment.success')
            ->with('success', 'Pago confirmado correctamente')
            ->with('order_id', $order->id);
    }

    /**
     * Verify discount code (AJAX)
     */
    public function verifyDiscount(Request $request)
    {
        $request->validate([
            'code' => 'required|string',
        ]);

        $discountCode = DiscountCode::where('code', $request->code)
            ->where('user_id', auth()->id())
            ->first();

        if (!$discountCode) {
            return response()->json([
                'success' => false,
                'message' => 'Código no válido o no pertenece a tu cuenta'
            ]);
        }

        if (!$discountCode->isValid()) {
            return response()->json([
                'success' => false,
                'message' => 'Este código ya fue usado o ha expirado'
            ]);
        }

        return response()->json([
            'success' => true,
            'discount_percentage' => $discountCode->discount_percentage,
            'message' => 'Código aplicado correctamente'
        ]);
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
