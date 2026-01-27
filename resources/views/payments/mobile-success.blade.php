@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card border-success">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-check-circle-fill text-success" viewBox="0 0 16 16">
                            <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                        </svg>
                    </div>

                    <h2 class="text-success mb-3">¡Compra Confirmada!</h2>
                    
                    <div class="alert alert-success">
                        <h5>✓ Pago procesado correctamente</h5>
                        <p class="mb-0">
                            La pantalla de tu ordenador se actualizará automáticamente.
                        </p>
                    </div>

                    <div class="card bg-light mt-4">
                        <div class="card-body">
                            <p class="mb-2">
                                <strong>Ya puedes cerrar esta ventana</strong>
                            </p>
                            <p class="text-muted small mb-0">
                                La compra ha sido procesada exitosamente.<br>
                                Puedes volver a tu ordenador.
                            </p>
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            Volver al Inicio
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
