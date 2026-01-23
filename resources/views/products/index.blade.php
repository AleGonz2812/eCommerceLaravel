@extends('layouts.app')

@section('title', 'Catálogo de Productos - MiTienda')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">
        <i class="bi bi-grid"></i> Catálogo de Productos
    </h1>
    
    @if(isset($query))
    <div class="alert alert-info">
        Resultados de búsqueda para: <strong>{{ $query }}</strong>
    </div>
    @endif
    
    <div class="row">
        @forelse($products as $product)
        <div class="col-md-6 col-lg-3 mb-4">
            <div class="card product-card">
                @if($product->featured)
                <span class="badge bg-warning text-dark badge-featured">
                    <i class="bi bi-star-fill"></i> Destacado
                </span>
                @endif
                
                <img 
                    src="{{ asset('storage/' . $product->image) }}" 
                    class="card-img-top product-image" 
                    alt="{{ $product->name }}"
                >
                
                <div class="card-body d-flex flex-column">
                    <span class="badge bg-secondary mb-2 align-self-start">
                        {{ $product->category->name }}
                    </span>
                    
                    <h5 class="card-title">{{ $product->name }}</h5>
                    
                    <p class="card-text text-muted small flex-grow-1">
                        {{ Str::limit($product->description, 80) }}
                    </p>
                    
                    <div class="d-flex justify-content-between align-items-center mt-3">
                        <span class="h4 text-primary mb-0">€{{ number_format($product->price, 2) }}</span>
                        <a href="{{ route('products.show', $product->slug) }}" class="btn btn-sm btn-outline-primary">
                            Ver más
                        </a>
                    </div>
                    
                    @if($product->stock > 0)
                        <small class="text-success mt-2">
                            <i class="bi bi-check-circle"></i> {{ $product->stock }} disponibles
                        </small>
                    @else
                        <small class="text-danger mt-2">
                            <i class="bi bi-x-circle"></i> Agotado
                        </small>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-info text-center">
                <i class="bi bi-inbox"></i> No se encontraron productos.
            </div>
        </div>
        @endforelse
    </div>
    
    <!-- Paginación -->
    <div class="d-flex justify-content-center mt-4">
        {{ $products->links() }}
    </div>
</div>
@endsection
