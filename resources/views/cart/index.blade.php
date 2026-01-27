@extends('layouts.app')

@section('title', 'Mi Carrito - PixelPlay')

@section('content')
<div class="container py-5">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="mb-0">
                    <i class="bi bi-cart3"></i> Mi Carrito de Compras
                </h1>
                @if($cartItems->count() > 0)
                    <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('¿Estás seguro de vaciar todo el carrito?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">
                            <i class="bi bi-trash"></i> Vaciar Carrito
                        </button>
                    </form>
                @endif
            </div>

            @if($cartItems->count() > 0)
                <div class="row">
                    <!-- Lista de productos -->
                    <div class="col-lg-8 mb-4">
                        <div class="card shadow-sm">
                            <div class="card-body p-0">
                                <div class="table-responsive">
                                    <table class="table table-hover mb-0">
                                        <thead class="table-light">
                                            <tr>
                                                <th scope="col" style="width: 100px;">Imagen</th>
                                                <th scope="col">Producto</th>
                                                <th scope="col" class="text-center" style="width: 120px;">Precio</th>
                                                <th scope="col" class="text-center" style="width: 150px;">Cantidad</th>
                                                <th scope="col" class="text-end" style="width: 120px;">Subtotal</th>
                                                <th scope="col" class="text-center" style="width: 80px;">Acción</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($cartItems as $item)
                                                <tr>
                                                    <!-- Imagen del producto -->
                                                    <td>
                                                        <img src="{{ asset('storage/' . $item->product->image) }}" 
                                                             alt="{{ $item->product->name }}" 
                                                             class="img-fluid rounded"
                                                             style="max-height: 80px; object-fit: cover;">
                                                    </td>
                                                    
                                                    <!-- Nombre del producto -->
                                                    <td class="align-middle">
                                                        <a href="{{ route('products.show', $item->product->slug) }}" 
                                                           class="text-decoration-none fw-bold">
                                                            {{ $item->product->name }}
                                                        </a>
                                                        <br>
                                                        <small class="text-muted">
                                                            Stock disponible: {{ $item->product->stock }}
                                                        </small>
                                                    </td>
                                                    
                                                    <!-- Precio unitario -->
                                                    <td class="align-middle text-center">
                                        <strong>{{ number_format($item->price, 2) }} €</strong>
                                                    <!-- Control de cantidad -->
                                                    <td class="align-middle">
                                                        <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex justify-content-center align-items-center gap-2">
                                                            @csrf
                                                            @method('PATCH')
                                                            <input type="number" 
                                                                   name="quantity" 
                                                                   value="{{ $item->quantity }}" 
                                                                   min="1" 
                                                                   max="{{ $item->product->stock }}"
                                                                   class="form-control form-control-sm text-center" 
                                                                   style="width: 70px;"
                                                                   onchange="this.form.submit()">
                                                        </form>
                                                    </td>
                                                    
                                                    <!-- Subtotal -->
                                                    <td class="align-middle text-end">
                                                        <strong class="text-primary">
                                            {{ number_format($item->price * $item->quantity, 2) }} €
                                                    <!-- Botón eliminar -->
                                                    <td class="align-middle text-center">
                                                        <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" 
                                                                    class="btn btn-sm btn-outline-danger"
                                                                    onclick="return confirm('¿Eliminar {{ $item->product->name }} del carrito?')">
                                                                <i class="bi bi-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <!-- Botón continuar comprando -->
                        <div class="mt-3">
                            <a href="{{ route('products.index') }}" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-left"></i> Continuar Comprando
                            </a>
                        </div>
                    </div>

                    <!-- Resumen del pedido -->
                    <div class="col-lg-4">
                        <div class="card shadow-sm sticky-top" style="top: 20px;">
                            <div class="card-header bg-primary text-white">
                                <h5 class="mb-0">
                                    <i class="bi bi-receipt"></i> Resumen del Pedido
                                </h5>
                            </div>
                            <div class="card-body">
                                <!-- Total -->
                                <div class="d-flex justify-content-between mb-2">
                                    <span>Total ({{ $cartItems->sum('quantity') }} productos):</span>
                                    <strong>{{ number_format($total, 2) }} €</strong>
                                </div>

                                <hr>

                                <!-- Total Final -->
                                <div class="d-flex justify-content-between mb-3">
                                    <h5 class="mb-0">Total a Pagar:</h5>
                                    <h5 class="mb-0 text-primary">
                                        {{ number_format($total, 2) }} €
                                    </h5>
                                </div>

                                <!-- Botón de checkout -->
                                <div class="d-grid gap-2">
                                    <a href="{{ route('payment.checkout') }}" class="btn btn-primary btn-lg">
                                        <i class="bi bi-credit-card"></i> Proceder al Pago
                                    </a>
                                </div>

                                <!-- Información adicional -->
                                <div class="mt-4">
                                    <div class="alert alert-info mb-0" role="alert">
                                        <i class="bi bi-shield-check"></i>
                                        <strong>Compra segura</strong>
                                        <br>
                                        <small>Tus datos están protegidos con encriptación SSL</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Carrito vacío -->
                <div class="card shadow-sm text-center py-5">
                    <div class="card-body">
                        <i class="bi bi-cart-x text-muted" style="font-size: 5rem;"></i>
                        <h3 class="mt-4 mb-3">Tu carrito está vacío</h3>
                        <p class="text-muted mb-4">
                            No has agregado ningún producto aún. ¡Explora nuestro catálogo y encuentra lo que buscas!
                        </p>
                        <a href="{{ route('products.index') }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-grid"></i> Ver Todos los Productos
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
