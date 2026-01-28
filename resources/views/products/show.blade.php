@extends('layouts.app')

@section('title', $product->name . ' - PixelPlay')

@section('content')
<div class="container mt-4">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Inicio</a></li>
            <li class="breadcrumb-item"><a href="{{ route('products.index') }}">Productos</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.show', $product->category->slug) }}">{{ $product->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $product->name }}</li>
        </ol>
    </nav>
    
    <div class="row">
        <div class="col-md-5">
            <img 
                src="{{ asset('storage/' . $product->image) }}" 
                class="img-fluid rounded shadow" 
                alt="{{ $product->name }}"
            >
        </div>
        
        <div class="col-md-7">
            @if($product->featured)
            <span class="badge bg-warning text-dark mb-2">
                <i class="bi bi-star-fill"></i> Producto Destacado
            </span>
            @endif
            
            <span class="badge bg-secondary mb-2">{{ $product->category->name }}</span>
            
            <h1 class="mb-3">{{ $product->name }}</h1>
            
            <h2 class="text-primary mb-4">€{{ number_format($product->price, 2) }}</h2>
            
            <p class="lead">{{ $product->description }}</p>
            
            @if($product->stock > 0)
                <div class="alert alert-success">
                    <i class="bi bi-check-circle"></i> <strong>En stock:</strong> {{ $product->stock }} unidades disponibles
                </div>
                
                @auth
                    @if(!Auth::user()->isAdmin())
                        <form action="{{ route('cart.add', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-cart-plus"></i> Añadir al Carrito
                            </button>
                        </form>
                    @else
                        <div class="alert alert-info">
                            <i class="bi bi-shield-check"></i> <strong>Modo Admin:</strong> No puedes realizar compras como admin
                        </div>
                    @endif
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary btn-lg">
                        <i class="bi bi-box-arrow-in-right"></i> Inicia Sesión para Comprar
                    </a>
                @endauth
            @else
                <div class="alert alert-danger">
                    <i class="bi bi-x-circle"></i> <strong>Agotado</strong> - Producto no disponible
                </div>
                
                <button class="btn btn-secondary btn-lg" disabled>
                    No Disponible
                </button>
            @endif
        </div>
    </div>
    
    @if($relatedProducts->count() > 0)
    <div class="row mt-5">
        <div class="col-12">
            <h3 class="mb-4">Productos Relacionados</h3>
        </div>
        
        @foreach($relatedProducts as $related)
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card product-card">
                <img 
                    src="{{ asset('storage/' . $related->image) }}" 
                    class="card-img-top product-image" 
                    alt="{{ $related->name }}"
                >
                
                <div class="card-body">
                    <h5 class="card-title">{{ $related->name }}</h5>
                    <p class="text-primary fw-bold">€{{ number_format($related->price, 2) }}</p>
                    <a href="{{ route('products.show', $related->slug) }}" class="btn btn-sm btn-outline-primary w-100">
                        Ver Producto
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
