<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Página de inicio
Route::get('/', [HomeController::class, 'index'])->name('home');

// Rutas de productos
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');
Route::get('/products/{slug}', [ProductController::class, 'show'])->name('products.show');

// Rutas de categorías
Route::get('/category/{slug}', [CategoryController::class, 'show'])->name('category.show');

// Rutas de autenticación
Route::middleware('guest')->group(function () {
    // Mostrar formulario de registro
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    // Procesar registro
    Route::post('/register', [AuthController::class, 'register']);
    
    // Mostrar formulario de login
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    // Procesar login
    Route::post('/login', [AuthController::class, 'login']);
});

// Rutas protegidas (requieren autenticación)
Route::middleware('auth')->group(function () {
    // Cerrar sesión
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Rutas del carrito
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::patch('/cart/update/{cartItem}', [CartController::class, 'updateQuantity'])->name('cart.update');
    Route::delete('/cart/remove/{cartItem}', [CartController::class, 'remove'])->name('cart.remove');
    Route::delete('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');
    
    // Rutas de pagos
    Route::get('/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::post('/payment/process', [PaymentController::class, 'processPayment'])->name('payment.process');
    Route::get('/payment/success', [PaymentController::class, 'success'])->name('payment.success');
    Route::get('/payment/pending', [PaymentController::class, 'pending'])->name('payment.pending');
    Route::get('/payment/confirm/{token}', [PaymentController::class, 'confirmPayment'])->name('payment.confirm');
    Route::post('/payment/confirm/{token}', [PaymentController::class, 'processConfirmation'])->name('payment.process-confirmation');
    Route::get('/payment/check-status', [PaymentController::class, 'checkStatus'])->name('payment.check-status');
    Route::post('/payment/stripe/checkout', [PaymentController::class, 'createCheckoutSession'])->name('payment.stripe.checkout');
    
    // Rutas de pedidos
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');
});

// Rutas de administración (solo para administradores)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Gestión de productos
    Route::resource('products', AdminProductController::class);
});
