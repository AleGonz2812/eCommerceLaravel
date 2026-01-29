@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1>
            <i class="bi bi-receipt"></i> Mis Pedidos
        </h1>
    </div>

    @if($orders->isEmpty())
        <!-- Sin pedidos -->
        <div class="card text-center py-5">
            <div class="card-body">
                <i class="bi bi-inbox display-1 text-muted"></i>
                <h3 class="mt-3">No tienes pedidos aún</h3>
                <p class="text-muted">Comienza a comprar tus juegos favoritos</p>
                <a href="{{ route('products.index') }}" class="btn btn-primary mt-3">
                    <i class="bi bi-shop"></i> Ver Productos
                </a>
            </div>
        </div>
    @else
        <!-- Lista de pedidos -->
        @foreach($orders as $order)
        <div class="card mb-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <div>
                    <strong>Pedido #{{ $order->order_number }}</strong>
                    <br>
                    <small class="text-muted">
                        <i class="bi bi-calendar"></i> 
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </small>
                </div>
                <div class="text-end">
                    <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                    <br>
                    <strong class="text-primary">{{ number_format($order->total, 2) }} €</strong>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-8">
                        <h6 class="mb-2">Productos ({{ $order->items->count() }})</h6>
                        <ul class="list-unstyled mb-0">
                            @foreach($order->items->take(3) as $item)
                            <li class="mb-1">
                                <i class="bi bi-box-seam text-primary"></i>
                                <strong>{{ $item->product_name }}</strong> 
                                <span class="text-muted">x{{ $item->quantity }}</span>
                                - {{ number_format($item->subtotal, 2) }} €
                            </li>
                            @endforeach
                            @if($order->items->count() > 3)
                            <li class="text-muted">
                                <i class="bi bi-three-dots"></i> 
                                Y {{ $order->items->count() - 3 }} producto(s) más
                            </li>
                            @endif
                        </ul>
                    </div>
                    <div class="col-md-4 text-end">
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-primary">
                            <i class="bi bi-eye"></i> Ver Detalles
                        </a>
                    </div>
                </div>
            </div>
        </div>
        @endforeach

        <!-- Paginación -->
        <div class="d-flex justify-content-center mt-4">
            {{ $orders->links() }}
        </div>
    @endif
</div>
@endsection
