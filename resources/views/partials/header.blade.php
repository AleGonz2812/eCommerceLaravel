<header class="bg-body-tertiary shadow-sm">
    <div class="container">
        <div class="row py-3 align-items-center">
            <!-- Logo -->
            <div class="col-md-3">
                <a href="{{ url('/') }}" class="navbar-brand text-primary text-decoration-none">
                    <i class="bi bi-shop"></i> PixelPlay
                </a>
            </div>
            
            <!-- Search Bar -->
            <div class="col-md-5">
                <form action="{{ route('products.search') }}" method="GET" class="d-flex">
                    <input 
                        type="search" 
                        name="q" 
                        class="form-control me-2" 
                        placeholder="Buscar productos..." 
                        aria-label="Buscar"
                    >
                    <button class="btn btn-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </form>
            </div>
            
            <!-- User Actions -->
            <div class="col-md-4 text-end">
                <div class="d-flex justify-content-end align-items-center gap-3">
                    <!-- Theme Toggle -->
                    <span class="theme-toggle" onclick="toggleTheme()" title="Cambiar tema">
                        <i id="theme-icon" class="bi bi-moon-stars-fill"></i>
                    </span>
                    
                    <!-- User Account -->
                    @auth
                        <div class="dropdown">
                            <a href="#" class="text-decoration-none text-body dropdown-toggle" 
                               id="userHeaderDropdown" 
                               data-bs-toggle="dropdown" 
                               aria-expanded="false" 
                               title="Mi cuenta">
                                <i class="bi bi-person-circle fs-4"></i>
                                <small class="d-none d-lg-inline ms-1">{{ Auth::user()->name }}</small>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userHeaderDropdown">
                                <li>
                                    <h6 class="dropdown-header">
                                        <i class="bi bi-person"></i> {{ Auth::user()->name }}
                                    </h6>
                                </li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('orders.index') }}">
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
                        </div>
                    @else
                        <a href="{{ route('login') }}" class="text-decoration-none text-body" title="Iniciar sesión">
                            <i class="bi bi-person-circle fs-4"></i>
                        </a>
                    @endauth
                    
                    <!-- Shopping Cart -->
                    <a href="{{ route('cart.index') }}" class="text-decoration-none text-body position-relative" title="Carrito">
                        <i class="bi bi-cart3 fs-4"></i>
                        @auth
                            @php
                                $cartCount = \App\Http\Controllers\CartController::getCartCount();
                            @endphp
                            @if($cartCount > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $cartCount }}
                                    <span class="visually-hidden">productos en el carrito</span>
                                </span>
                            @endif
                        @endauth
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
