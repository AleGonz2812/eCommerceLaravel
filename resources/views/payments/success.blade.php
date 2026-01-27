@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                    </div>
                    
                    <h2 class="mb-3">¡Pago Exitoso!</h2>
                    <p class="text-muted mb-4">Tu pedido ha sido procesado correctamente.</p>
                    
                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif
                    
                    @if(session('order_id'))
                        <div class="alert alert-info">
                            <i class="bi bi-envelope-check"></i>
                            <strong>Se ha enviado un email</strong> con tus keys de activación.
                        </div>
                    @endif

                    <div class="d-grid gap-2 mt-4">
                        @if(session('order_id'))
                            <a href="{{ route('orders.show', session('order_id')) }}" class="btn btn-success">
                                <i class="bi bi-receipt"></i> Ver mi Pedido y Keys
                            </a>
                        @endif
                        <a href="{{ route('orders.index') }}" class="btn btn-primary">
                            <i class="bi bi-bag-check"></i> Ver Todos mis Pedidos
                        </a>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                            Continuar Comprando
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
