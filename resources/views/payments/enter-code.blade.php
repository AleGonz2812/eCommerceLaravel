@extends('layouts.app')

@section('title', 'Confirmar Compra')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="bi bi-shield-check me-2"></i>Confirmación de Compra
                    </h4>
                </div>
                <div class="card-body p-4">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            <i class="bi bi-exclamation-circle"></i> {{ session('error') }}
                        </div>
                    @endif

                    <div class="text-center mb-4">
                        <i class="bi bi-envelope-check" style="font-size: 4rem; color: #0d6efd;"></i>
                        <h5 class="mt-3">Revisa tu correo electrónico</h5>
                        <p class="text-muted">
                            Hemos enviado un código de confirmación de 6 dígitos a tu correo.
                            Introdúcelo a continuación para completar tu compra.
                        </p>
                    </div>

                    <form action="{{ route('payment.verify-code') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="code" class="form-label fw-bold">Código de Confirmación</label>
                            <input 
                                type="text" 
                                class="form-control form-control-lg text-center @error('code') is-invalid @enderror" 
                                id="code"
                                name="code" 
                                placeholder="000000"
                                maxlength="6"
                                pattern="\d{6}"
                                required
                                autofocus
                                style="letter-spacing: 10px; font-size: 2rem; font-family: 'Courier New', monospace;"
                            >
                            @error('code')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Introduce el código de 6 dígitos que recibiste por correo</small>
                        </div>

                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-success btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Confirmar Compra
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-left me-2"></i>Volver al Inicio
                            </a>
                        </div>
                    </form>

                    <div class="alert alert-warning mt-4" style="font-size: 0.9rem;">
                        <strong><i class="bi bi-exclamation-triangle"></i> Importante:</strong>
                        <ul class="mb-0 mt-2">
                            <li>El código expira en <strong>24 horas</strong></li>
                            <li>Solo puedes usar el código una vez</li>
                            <li>Si no reconoces esta compra, ignórala</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-formatear el código mientras el usuario escribe
document.getElementById('code').addEventListener('input', function(e) {
    let value = e.target.value.replace(/\D/g, ''); // Solo números
    e.target.value = value.substring(0, 6); // Máximo 6 dígitos
});
</script>
@endsection
