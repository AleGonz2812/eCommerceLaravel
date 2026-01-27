@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <div class="card">
                <div class="card-body py-5">
                    <div class="mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="currentColor" class="bi bi-credit-card-2-front text-primary" viewBox="0 0 16 16">
                            <path d="M14 3a1 1 0 0 1 1 1v8a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12zM2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V4a2 2 0 0 0-2-2H2z"/>
                            <path d="M2 5.5a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-2a.5.5 0 0 1-.5-.5v-1zm0 3a.5.5 0 0 1 .5-.5h5a.5.5 0 0 1 0 1h-5a.5.5 0 0 1-.5-.5zm0 2a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5zm3 0a.5.5 0 0 1 .5-.5h1a.5.5 0 0 1 0 1h-1a.5.5 0 0 1-.5-.5z"/>
                        </svg>
                    </div>

                    <h2 class="mb-3">Confirma tu Compra</h2>
                    
                    <div class="alert alert-info mb-4">
                        <h4 class="mb-3">Total a pagar</h4>
                        <h1 class="display-4 text-primary">
                            €{{ number_format($paymentConfirmation->amount, 2) }}
                        </h1>
                    </div>

                    <p class="text-dark mb-4">
                        Haz clic en el botón de abajo para confirmar tu compra.<br>
                        La pantalla del ordenador se actualizará automáticamente.
                    </p>

                    <form action="{{ route('payment.process-confirmation', $paymentConfirmation->token) }}" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-success btn-lg w-100 py-3">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" class="bi bi-check-circle-fill me-2" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zm-3.97-3.03a.75.75 0 0 0-1.08.022L7.477 9.417 5.384 7.323a.75.75 0 0 0-1.06 1.06L6.97 11.03a.75.75 0 0 0 1.079-.02l3.992-4.99a.75.75 0 0 0-.01-1.05z"/>
                            </svg>
                            Confirmar Compra
                        </button>
                    </form>

                    <div class="alert alert-warning mt-4">
                        <small>
                            <strong>⚠️ Importante:</strong><br>
                            Este enlace expira en 24 horas y solo puede usarse una vez.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
