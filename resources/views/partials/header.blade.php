<header class="bg-body-tertiary shadow-sm">
    <div class="container">
        <div class="row py-3 align-items-center">
            <!-- Logo -->
            <div class="col-md-3">
                <a href="{{ url('/') }}" class="navbar-brand text-primary text-decoration-none">
                    <i class="bi bi-shop"></i> MiTienda
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
                    <a href="#" class="text-decoration-none text-body" title="Mi cuenta">
                        <i class="bi bi-person-circle fs-4"></i>
                    </a>
                    
                    <!-- Shopping Cart -->
                    <a href="{{ route('cart.index') }}" class="text-decoration-none text-body position-relative" title="Carrito">
                        <i class="bi bi-cart3 fs-4"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            0
                            <span class="visually-hidden">productos en el carrito</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>
