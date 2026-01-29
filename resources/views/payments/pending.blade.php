@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="80" height="80" fill="currentColor" class="bi bi-envelope-check text-warning" viewBox="0 0 16 16">
                            <path d="M2 2a2 2 0 0 0-2 2v8.01A2 2 0 0 0 2 14h5.5a.5.5 0 0 0 0-1H2a1 1 0 0 1-.966-.741l5.64-3.471L8 9.583l7-4.2V8.5a.5.5 0 0 0 1 0V4a2 2 0 0 0-2-2H2Zm3.708 6.208L1 11.105V5.383l4.708 2.825ZM1 4.217V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v.217l-7 4.2-7-4.2Z"/>
                            <path d="M16 12.5a3.5 3.5 0 1 1-7 0 3.5 3.5 0 0 1 7 0Zm-1.993-1.679a.5.5 0 0 0-.686.172l-1.17 1.95-.547-.547a.5.5 0 0 0-.708.708l.774.773a.75.75 0 0 0 1.174-.144l1.335-2.226a.5.5 0 0 0-.172-.686Z"/>
                        </svg>
                    </div>
                    
                    <h2 class="mb-3">Confirmación Requerida</h2>
                    <p class="text-muted mb-4">Tu compra supera los 100 €</p>
                    
                    @if(session('info'))
                        <div class="alert alert-info">
                            {{ session('info') }}
                        </div>
                    @endif

                    <div class="alert alert-warning" id="waiting-alert">
                        <div class="spinner-border spinner-border-sm me-2" role="status">
                            <span class="visually-hidden">Esperando...</span>
                        </div>
                        <strong>📧 Revisa tu correo electrónico</strong>
                        <p class="mt-2 mb-0">
                            Hemos enviado un enlace de confirmación a tu correo.<br>
                            Abre el enlace en tu móvil y confirma la compra.
                        </p>
                        <p class="mt-2 mb-0 small text-muted">
                            <em>Esta página se actualizará automáticamente cuando confirmes...</em>
                        </p>
                    </div>

                    <div class="card bg-light mt-4">
                        <div class="card-body">
                            <h6 class="card-title text-dark">⏰ Información Importante</h6>
                            <ul class="list-unstyled text-start mb-0 text-dark">
                                <li class="mb-2">✓ El enlace expira en <strong>24 horas</strong></li>
                                <li class="mb-2">✓ Revisa también tu carpeta de spam</li>
                                <li class="mb-2">✓ Solo puedes usar el enlace una vez</li>
                                <li>✓ Tu carrito se mantendrá guardado</li>
                            </ul>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            Volver al Inicio
                        </a>
                        <a href="{{ route('cart.index') }}" class="btn btn-outline-secondary">
                            Ver mi Carrito
                        </a>
                    </div>

                    <p class="text-muted mt-4 small">
                        <i class="bi bi-shield-check"></i>
                        Este proceso adicional protege tu cuenta de transacciones no autorizadas
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Verificar cada 3 segundos si la compra fue confirmada(ajax)
let checkInterval = setInterval(function() {
    fetch('{{ route("payment.check-status") }}', {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.confirmed) {
            clearInterval(checkInterval);
            // Redirigir a la página de éxito
            window.location.href = '{{ route("payment.success") }}';
        }
    })
    .catch(error => console.log('Verificando...'));
}, 3000); // Cada 3 segundos
</script>
@endsection
