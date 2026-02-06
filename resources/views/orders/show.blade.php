@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <!-- Header -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1>
                <i class="bi bi-receipt-cutoff"></i> Detalle del Pedido
            </h1>
            <p class="text-muted mb-0">
                Número de pedido: <strong>{{ $order->order_number }}</strong>
            </p>
        </div>
        <a href="{{ route('orders.index') }}" class="btn btn-outline-secondary">
            <i class="bi bi-arrow-left"></i> Volver a mis pedidos
        </a>
    </div>

    <div class="row">
        <!-- Información del pedido -->
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-box-seam"></i> Productos Comprados
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>Producto</th>
                                    <th class="text-center">Cantidad</th>
                                    <th class="text-end">Precio Unit.</th>
                                    <th class="text-end">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->items as $item)
                                <tr>
                                    <td>
                                        <strong>{{ $item->product_name }}</strong>
                                        @if($item->product)
                                            <br>
                                            <small class="text-muted">
                                                <a href="{{ route('products.show', $item->product->slug) }}" class="text-decoration-none">
                                                    Ver producto <i class="bi bi-box-arrow-up-right"></i>
                                                </a>
                                            </small>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="badge bg-secondary">x{{ $item->quantity }}</span>
                                    </td>
                                    <td class="text-end">{{ number_format($item->price, 2) }} €</td>
                                    <td class="text-end">
                                        <strong class="text-primary">{{ number_format($item->subtotal, 2) }} €</strong>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="table-light">
                                    <th colspan="3" class="text-end">Total del Pedido:</th>
                                    <th class="text-end">
                                        <h5 class="mb-0 text-primary">{{ number_format($order->total, 2) }} €</h5>
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Keys de productos -->
            <div class="card">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-key-fill"></i> Keys de Activación
                    </h5>
                </div>
                <div class="card-body">
                    @foreach($order->items as $item)
                    <div class="mb-3 p-3 border rounded">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <strong>{{ $item->product_name }}</strong>
                            <span class="badge bg-secondary">x{{ $item->quantity }}</span>
                        </div>
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control font-monospace" 
                                   value="{{ $item->product_key }}" 
                                   readonly 
                                   id="key-{{ $item->id }}">
                            <button class="btn btn-outline-primary" 
                                    type="button" 
                                    onclick="copyKey('{{ $item->id }}')">
                                <i class="bi bi-clipboard"></i> Copiar
                            </button>
                        </div>
                        @if(stripos($item->product_key, '[') !== false)
                        <small class="text-success">
                            <i class="bi bi-gift-fill"></i> ¡Mystery Key revelada!
                        </small>
                        @endif
                    </div>
                    @endforeach

                    <div class="alert alert-info mt-3">
                        <i class="bi bi-info-circle"></i>
                        <strong>Importante:</strong> Guarda estas keys en un lugar seguro. 
                        Puedes consultarlas en cualquier momento desde tu historial de pedidos.
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar con información -->
        <div class="col-lg-4">
            <!-- Estado del pedido -->
            <div class="card mb-4">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-info-circle"></i> Estado del Pedido
                    </h6>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Estado:</span>
                        <span class="badge bg-success">{{ ucfirst($order->status) }}</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Fecha:</span>
                        <strong>{{ $order->created_at->format('d/m/Y') }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span>Hora:</span>
                        <strong>{{ $order->created_at->format('H:i') }}</strong>
                    </div>
                </div>
            </div>

            <!-- Resumen -->
            <div class="card">
                <div class="card-body">
                    <h6 class="card-title">
                        <i class="bi bi-receipt"></i> Resumen
                    </h6>
                    <hr>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Productos:</span>
                        <strong>{{ $order->items->count() }}</strong>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Unidades totales:</span>
                        <strong>{{ $order->items->sum('quantity') }}</strong>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <strong>Total Pagado:</strong>
                        <h5 class="mb-0 text-primary">{{ number_format($order->total, 2) }} €</h5>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyKey(itemId) {
    const input = document.getElementById('key-' + itemId);
    input.select();
    document.execCommand('copy');
    
    // Feedback visual
    const button = event.target.closest('button');
    const originalHTML = button.innerHTML;
    button.innerHTML = '<i class="bi bi-check"></i> Copiado';
    button.classList.remove('btn-outline-primary');
    button.classList.add('btn-success');
    
    setTimeout(() => {
        button.innerHTML = originalHTML;
        button.classList.remove('btn-success');
        button.classList.add('btn-outline-primary');
    }, 2000);
}
</script>
@endsection
