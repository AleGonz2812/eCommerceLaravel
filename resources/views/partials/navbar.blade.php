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
                @isset($categories)
                    @foreach($categories as $category)
                    <li class="nav-item">
                        <a class="nav-link {{ request()->is('category/'.$category->slug) ? 'active' : '' }}" 
                           href="{{ route('category.show', $category->slug) }}">
                            {{ $category->name }}
                        </a>
                    </li>
                    @endforeach
                @endisset
            </ul>
            
            <!-- Enlaces adicionales -->
            <ul class="navbar-nav">
                @auth
                    <!-- Carrito de compras -->
                    <li class="nav-item">
                        <a class="nav-link position-relative {{ request()->is('cart') ? 'active' : '' }}" href="{{ route('cart.index') }}">
                            <i class="bi bi-cart3"></i> Carrito
                            @php
                                $cartCount = \App\Http\Controllers\CartController::getCartCount();
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cartCount }}
                                </span>
                            @endif
                        </a>
                    </li>
                    
                    <!-- Usuario autenticado -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person-circle"></i> {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                            <li>
                                <a class="dropdown-item" href="#">
                                    <i class="bi bi-bag-check"></i> Mis Pedidos
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item text-danger">
                                        <i class="bi bi-box-arrow-right"></i> Cerrar Sesión
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @else
                    <!-- Usuario invitado -->
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('login') }}">
                            <i class="bi bi-box-arrow-in-right"></i> Iniciar Sesión
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('register') }}">
                            <i class="bi bi-person-plus"></i> Registrarse
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
