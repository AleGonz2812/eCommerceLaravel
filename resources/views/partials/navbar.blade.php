<nav class="navbar navbar-expand-lg bg-primary" data-bs-theme="dark">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">
                        <i class="bi bi-house-door"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('products') ? 'active' : '' }}" href="{{ route('products.index') }}">
                        <i class="bi bi-grid"></i> Todos los Productos
                    </a>
                </li>
                
                <!-- Categorías dinámicas (compartidas vía ViewComposer) -->
                @foreach($categories as $category)
                <li class="nav-item">
                    <a class="nav-link {{ request()->is('category/'.$category->slug) ? 'active' : '' }}" 
                       href="{{ route('category.show', $category->slug) }}">
                        {{ $category->name }}
                    </a>
                </li>
                @endforeach
            </ul>
            
            <!-- Enlaces adicionales -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-question-circle"></i> Ayuda
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
