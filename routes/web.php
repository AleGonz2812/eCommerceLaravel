<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\AuthController;

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
    
    // Ruta del carrito (temporal - se implementará en NIVEL INTERMEDIO)
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
});
