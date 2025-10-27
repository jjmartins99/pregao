<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <!-- Logo -->
        <a class="navbar-brand" href="{{ route('marketplace.index') }}">
            <img src="{{ asset('images/logo.png') }}" alt="PREGÃO" height="40">
            <span class="ms-2 fw-bold">PREGÃO</span>
        </a>

        <!-- Mobile Toggle -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>

        <!-- Navbar Content -->
        <div class="collapse navbar-collapse" id="navbarContent">
            <!-- Search Form -->
            <form class="d-flex mx-auto my-2 my-lg-0" style="max-width: 500px; width: 100%;">
                <div class="input-group">
                    <input type="search" class="form-control" placeholder="Pesquisar produtos..." 
                           aria-label="Pesquisar" id="searchInput">
                    <button class="btn btn-primary" type="submit">
                        <i class="fas fa-search"></i>
                    </button>
                </div>
            </form>

            <!-- Navigation Links -->
            <ul class="navbar-nav ms-auto">
                <!-- Categories Dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-list me-1"></i>Categorias
                    </a>
                    <ul class="dropdown-menu">
                        @foreach($categories as $category)
                        <li>
                            <a class="dropdown-item" href="{{ route('marketplace.category', $category->slug) }}">
                                {{ $category->name }}
                            </a>
                        </li>
                        @endforeach
                    </ul>
                </li>

                <!-- Stores -->
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('stores.index') }}">
                        <i class="fas fa-store me-1"></i>Lojas
                    </a>
                </li>

                <!-- Cart -->
                <li class="nav-item">
                    <a class="nav-link position-relative" href="#" id="cartToggle">
                        <i class="fas fa-shopping-cart me-1"></i>Carrinho
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" 
                              id="cartCount">
                            {{ Cart::count() }}
                        </span>
                    </a>
                </li>

                <!-- User Account -->
                @auth
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="fas fa-user me-1"></i>{{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('profile.edit') }}">Perfil</a></li>
                        <li><a class="dropdown-item" href="{{ route('orders.index') }}">Meus Pedidos</a></li>
                        
                        @if(Auth::user()->hasRole('seller'))
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('stores.dashboard') }}">Minha Loja</a></li>
                        @endif
                        
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="dropdown-item">Sair</button>
                            </form>
                        </li>
                    </ul>
                </li>
                @else
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('login') }}">
                        <i class="fas fa-sign-in-alt me-1"></i>Entrar
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('register') }}">
                        <i class="fas fa-user-plus me-1"></i>Registar
                    </a>
                </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>