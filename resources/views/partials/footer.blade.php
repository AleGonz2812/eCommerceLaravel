<footer class="bg-body-tertiary mt-5 py-4 border-top">
    <div class="container">
        <div class="row">
            <!-- Información de la tienda -->
            <div class="col-md-4 mb-3">
                <h5 class="text-primary">
                    <i class="bi bi-shop"></i> PixelPlay
                </h5>
                <p class="text-muted">
                    Tu tienda de confianza para productos digitales: videojuegos, suscripciones, tarjetas y software.
                </p>
            </div>
            
            <!-- Enlaces rápidos -->
            <div class="col-md-4 mb-3">
                <h6>Enlaces Rápidos</h6>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/') }}" class="text-muted text-decoration-none">Inicio</a></li>
                    <li><a href="{{ route('products.index') }}" class="text-muted text-decoration-none">Productos</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Sobre Nosotros</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Contacto</a></li>
                </ul>
            </div>
            
            <!-- Información legal -->
            <div class="col-md-4 mb-3">
                <h6>Legal</h6>
                <ul class="list-unstyled">
                    <li><a href="#" class="text-muted text-decoration-none">Términos y Condiciones</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Política de Privacidad</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Política de Devoluciones</a></li>
                    <li><a href="#" class="text-muted text-decoration-none">Preguntas Frecuentes</a></li>
                </ul>
            </div>
        </div>
        
        <hr class="my-4">
        
        <!-- Copyright y redes sociales -->
        <div class="row align-items-center">
            <div class="col-md-6 text-center text-md-start">
                <p class="text-muted mb-0">
                    &copy; {{ date('Y') }} PixelPlay. Todos los derechos reservados.
                </p>
            </div>
            <div class="col-md-6 text-center text-md-end">
                <a href="#" class="text-muted me-3" title="Facebook">
                    <i class="bi bi-facebook fs-5"></i>
                </a>
                <a href="#" class="text-muted me-3" title="Twitter">
                    <i class="bi bi-twitter fs-5"></i>
                </a>
                <a href="#" class="text-muted me-3" title="Instagram">
                    <i class="bi bi-instagram fs-5"></i>
                </a>
                <a href="#" class="text-muted" title="Discord">
                    <i class="bi bi-discord fs-5"></i>
                </a>
            </div>
        </div>
    </div>
</footer>
