@extends('layouts.app')

@section('title', 'PixelPlay - Productos Digitales')

@section('content')
<div class="container mt-4">
    <!-- Hero Section -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="p-5 bg-primary text-white rounded-3 text-center hero-section">
                <h1 class="display-4 fw-bold">Bienvenido a PixelPlay</h1>
                <p class="lead">Los mejores precios en videojuegos, suscripciones y software</p>
                <a href="{{ route('products.index') }}" class="btn btn-light btn-lg mt-3">
                    <i class="bi bi-grid"></i> Ver Todos los Productos
                </a>
            </div>
        </div>
    </div>
    
    <!-- Categorías -->
    <div class="row mb-5">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="bi bi-tags"></i> Categorías
            </h2>
        </div>
        @foreach($categories as $category)
        <div class="col-md-4 col-lg mb-3">
            <a href="{{ route('category.show', $category->slug) }}" class="category-card">
                <div class="card h-100 border-primary">
                    <div class="card-body text-center">
                        <i class="bi bi-folder category-icon text-primary mb-2"></i>
                        <h5 class="card-title">{{ $category->name }}</h5>
                        <p class="text-muted small mb-0">
                            {{ $category->products->count() }} productos
                        </p>
                    </div>
                </div>
            </a>
        </div>
        @endforeach
    </div>
    
    <!-- Productos Destacados -->
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4">
                <i class="bi bi-star-fill text-warning"></i> Productos Destacados
            </h2>
        </div>
        
        @forelse($featuredProducts as $product)
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card product-card">
                <!-- Badge de destacado -->
                <span class="badge bg-warning text-dark badge-featured">
                    <i class="bi bi-star-fill"></i> Destacado
                </span>
                
                <!-- Imagen del producto -->
                <img 
                    src="{{ asset('storage/' . $product->image) }}" 
                    class="card-img-top product-image" 
                    alt="{{ $product->name }}"
                >
                
                <div class="card-body d-flex flex-column">
                    <!-- Categoría -->
                    <span class="badge bg-secondary mb-2 align-self-start">
                        {{ $product->category->name }}
                    </span>
                    
                    <!-- Nombre del producto -->
                    <h5 class="card-title">{{ $product->name }}</h5>
                    
                    <!-- Descripción corta -->
                    <p class="card-text text-muted small flex-grow-1">
                        {{ Str::limit($product->description, 80) }}
                    </p>
                    
                    <!-- Precio y botones -->
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="h4 text-primary mb-0">€{{ number_format($product->price, 2) }}</span>
                        <div>
                            <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary">
                                Ver más
                            </a>
                        </div>
                    </div>
                    
                    <!-- Stock y botón agregar -->
                    @if($product->stock > 0)
                        <div class="mt-3 d-grid gap-2">
                            @auth
                                @if(!Auth::user()->isAdmin())
                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-primary btn-sm w-100">
                                            <i class="bi bi-cart-plus"></i> Añadir al Carrito
                                        </button>
                                    </form>
                                @else
                                    <span class="badge bg-secondary w-100 py-2">
                                        <i class="bi bi-shield-check"></i> Modo Admin
                                    </span>
                                @endif
                            @else
                                <a href="{{ route('login') }}" class="btn btn-outline-primary btn-sm">
                                    <i class="bi bi-box-arrow-in-right"></i> Inicia Sesión
                                </a>
                            @endauth
                        </div>
                        <small class="text-success mt-2 d-block">
                            <i class="bi bi-check-circle"></i> {{ $product->stock }} disponibles
                        </small>
                    @else
                        <small class="text-danger mt-2 d-block">
                            <i class="bi bi-x-circle"></i> Agotado
                        </small>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-info-circle"></i> No hay productos destacados disponibles.
            </div>
        </div>
        @endforelse
    </div>
    
    <!-- Call to Action -->
    <div class="row mt-5 mb-4">
        <div class="col-12">
            <div class="card bg-dark text-white">
                <div class="card-body text-center py-5">
                    <h3>¿No encuentras lo que buscas?</h3>
                    <p class="lead">Explora nuestro catálogo completo con más de {{ $totalProducts }} productos</p>
                    <a href="{{ route('products.index') }}" class="btn btn-light btn-lg">
                        Explorar Catálogo Completo
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
