@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <h2 class="mb-4">Checkout</h2>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <div class="card mb-4">
                <div class="card-header">
                    <h5>Resumen del Pedido</h5>
                </div>
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Producto</th>
                                <th>Cantidad</th>
                                <th>Precio</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($cartItems as $item)
                            <tr>
                                <td>{{ $item->product->name }}</td>
                                <td>{{ $item->quantity }}</td>
                                <td>€{{ number_format($item->product->price, 2) }}</td>
                                <td>€{{ number_format($item->product->price * $item->quantity, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="3" class="text-end">Total:</th>
                                <th>€{{ number_format($total, 2) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h5>Información de Pago</h5>
                    <small class="text-muted">Simulación ficticia - Usa una tarjeta que termine en número par para que el pago sea exitoso</small>
                </div>
                <div class="card-body">
                    <form action="{{ route('payment.process') }}" method="POST">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="card_name" class="form-label">Nombre en la Tarjeta</label>
                            <input type="text" class="form-control @error('card_name') is-invalid @enderror" 
                                   id="card_name" name="card_name" value="{{ old('card_name') }}" required>
                            @error('card_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="card_number" class="form-label">Número de Tarjeta</label>
                            <input type="text" class="form-control @error('card_number') is-invalid @enderror" 
                                   id="card_number" name="card_number" placeholder="1234 5678 9012 3456" 
                                   maxlength="16" value="{{ old('card_number') }}" required>
                            <small class="text-muted">Ejemplos: 4242424242424242 (exitoso), 4242424242424243 (fallido)</small>
                            @error('card_number')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="expiry_date" class="form-label">Fecha de Expiración</label>
                                <input type="text" class="form-control @error('expiry_date') is-invalid @enderror" 
                                       id="expiry_date" name="expiry_date" placeholder="MM/YY" 
                                       maxlength="5" value="{{ old('expiry_date') }}" required>
                                @error('expiry_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="cvv" class="form-label">CVV</label>
                                <input type="text" class="form-control @error('cvv') is-invalid @enderror" 
                                       id="cvv" name="cvv" placeholder="123" maxlength="3" 
                                       value="{{ old('cvv') }}" required>
                                @error('cvv')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg">
                                Pagar €{{ number_format($total, 2) }}
                            </button>
                            <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                                Volver al Carrito
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // Format card number with spaces
    document.getElementById('card_number').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\s/g, '');
        e.target.value = value;
    });

    // Format expiry date
    document.getElementById('expiry_date').addEventListener('input', function(e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2, 4);
        }
        e.target.value = value;
    });

    // Only allow numbers in CVV
    document.getElementById('cvv').addEventListener('input', function(e) {
        e.target.value = e.target.value.replace(/\D/g, '');
    });
</script>
@endsection
