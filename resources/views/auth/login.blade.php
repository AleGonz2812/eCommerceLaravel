@extends('layouts.app')

@section('title', 'Iniciar Sesión - PixelPlay')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <div class="text-center mb-4">
                        <i class="bi bi-box-arrow-in-right text-primary" style="font-size: 3rem;"></i>
                        <h2 class="mt-3 mb-1">Iniciar Sesión</h2>
                        <p class="text-muted">Accede a tu cuenta</p>
                    </div>

                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="bi bi-exclamation-triangle-fill me-2"></i>
                            <strong>Error:</strong> {{ $errors->first() }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="bi bi-envelope"></i> Correo Electrónico
                            </label>
                            <input type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   id="email" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   autofocus
                                   placeholder="tucorreo@ejemplo.com">
                            @error('email')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Contraseña -->
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="bi bi-lock"></i> Contraseña
                            </label>
                            <input type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   id="password" 
                                   name="password" 
                                   required
                                   placeholder="Tu contraseña">
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Recordarme -->
                        <div class="mb-4">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       name="remember" 
                                       id="remember">
                                <label class="form-check-label" for="remember">
                                    Recordarme en este dispositivo
                                </label>
                            </div>
                        </div>

                        <!-- Botón de login -->
                        <div class="d-grid mb-3">
                            <button type="submit" class="btn btn-primary btn-lg">
                                <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                            </button>
                        </div>

                        <!-- Link a registro -->
                        <div class="text-center">
                            <p class="mb-0">
                                ¿No tienes cuenta? 
                                <a href="{{ route('register') }}" class="text-decoration-none">
                                    <strong>Regístrate Gratis</strong>
                                </a>
                            </p>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Información adicional -->
            <div class="text-center mt-4">
                <div class="text-muted mb-2">
                    <small>
                        <i class="bi bi-shield-check"></i> 
                        Conexión segura y cifrada
                    </small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
