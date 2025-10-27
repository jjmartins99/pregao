<nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
    <div class="container">
        {{-- Logo --}}
        <a class="navbar-brand fw-bold text-primary" href="{{ route('marketplace.index') }}">
            <i class="fas fa-store me-2"></i> PREGÃO
        </a>

        {{-- Botão mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarMain">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Menu --}}
        <div class="collapse navbar-collapse" id="navbarMain">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('marketplace.categories') }}">
                        Categorias
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('marketplace.stores') }}">
                        Lojas
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ route('marketplace.compare') }}">
                        <i class="fas fa-balance-scale me-1"></i> Comparar
                    </a>
                </li>
            </ul>

            {{-- Carrinho --}}
            <ul class="navbar-nav ms-3">
                <li class="nav-item">
                    <button class="btn btn-outline-primary position-relative" id="cartToggle">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                            {{ session('cart.count', 0) }}
                        </span>
                    </button>
                </li>
            </ul>

            {{-- Autenticação --}}
            <ul class="navbar-nav ms-3">
                @guest
                    <li class="nav-item">
                        <a class="btn btn-primary ms-2" href="{{ route('login') }}">Entrar</a>
                    </li>
                @else
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle fw-bold" href="#" data-bs-toggle="dropdown">
                            {{ Auth::user()->name }}
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            @if(Auth::user()->is_vendor)
                                <li>
                                    <a class="dropdown-item" href="{{ route('vendor.dashboard') }}">
                                        <i class="fas fa-store me-2"></i> Minha Loja
                                    </a>
                                </li>
                            @endif
                            <li>
                                <a class="dropdown-item" href="{{ route('profile') }}">
                                    <i class="fas fa-user me-2"></i> Perfil
                                </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">
                                        <i class="fas fa-sign-out-alt me-2"></i> Sair
                                    </button>
                                </form>
                            </li>
                        </ul>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
