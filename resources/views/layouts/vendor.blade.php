<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lojista - @yield('page-title', 'Painel do Vendedor')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://kit.fontawesome.com/a2e0f1f5b6.js" crossorigin="anonymous"></script>
    @stack('styles')
</head>
<body>
    <div id="vendor-dashboard" class="d-flex">
        <!-- Sidebar -->
        <aside class="bg-dark text-white p-3 vh-100" style="width:250px;">
            <div class="d-flex align-items-center mb-4">
                <i class="fas fa-store fa-2x me-2"></i>
                <span class="fw-bold">Painel do Lojista</span>
            </div>
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a href="{{ route('vendor.dashboard') }}" class="nav-link text-white {{ request()->routeIs('vendor.dashboard') ? 'active fw-bold' : '' }}">
                        <i class="fas fa-home me-2"></i> Dashboard
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('vendor.products.index') }}" class="nav-link text-white {{ request()->is('vendor/products*') ? 'active fw-bold' : '' }}">
                        <i class="fas fa-box me-2"></i> Produtos
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('vendor.orders.index') }}" class="nav-link text-white {{ request()->is('vendor/orders*') ? 'active fw-bold' : '' }}">
                        <i class="fas fa-shopping-cart me-2"></i> Encomendas
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('vendor.store.edit') }}" class="nav-link text-white {{ request()->is('vendor/store*') ? 'active fw-bold' : '' }}">
                        <i class="fas fa-store-alt me-2"></i> A Minha Loja
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a href="{{ route('vendor.settings') }}" class="nav-link text-white {{ request()->is('vendor/settings*') ? 'active fw-bold' : '' }}">
                        <i class="fas fa-cog me-2"></i> Definições
                    </a>
                </li>
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow-1">
            <!-- Topbar -->
            <nav class="navbar navbar-expand navbar-light bg-light border-bottom px-3">
                <div class="ms-auto d-flex align-items-center">
                    <span class="me-3 text-muted">
                        <i class="fas fa-user-circle me-1"></i> {{ auth()->user()->name }}
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-sm btn-outline-danger">
                            <i class="fas fa-sign-out-alt"></i> Sair
                        </button>
                    </form>
                </div>
            </nav>

            <!-- Page Header -->
            <header class="p-4 border-bottom">
                <h1 class="h3 mb-0">@yield('page-title')</h1>
                <small class="text-muted">@yield('page-subtitle')</small>
            </header>

            <!-- Page Content -->
            <div class="p-4">
                @yield('vendor-content')
            </div>
        </main>
    </div>

    <!-- Sidebar -->
<div class="sidebar bg-dark text-white p-3 vh-100">
    <h5 class="mb-4">Painel do Lojista</h5>
    <ul class="nav flex-column">
        <li class="nav-item mb-2">
            <a href="{{ route('vendor.dashboard') }}" 
               class="nav-link text-white {{ request()->routeIs('vendor.dashboard') ? 'active fw-bold' : '' }}">
                <i class="fas fa-home me-2"></i> Dashboard
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('vendor.products.index') }}" 
               class="nav-link text-white {{ request()->routeIs('vendor.products.*') ? 'active fw-bold' : '' }}">
                <i class="fas fa-box me-2"></i> Produtos
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('vendor.orders.index') }}" 
               class="nav-link text-white {{ request()->routeIs('vendor.orders.*') ? 'active fw-bold' : '' }}">
                <i class="fas fa-shopping-cart me-2"></i> Encomendas
            </a>
        </li>

        <!-- Novo link direto para Relatórios de Vendas -->
        <li class="nav-item mb-2">
            <a href="{{ route('vendor.sales') }}" 
               class="nav-link text-white {{ request()->routeIs('vendor.sales') ? 'active fw-bold' : '' }}">
                <i class="fas fa-chart-line me-2"></i> Relatórios de Vendas
            </a>
        </li>

        <li class="nav-item mb-2">
            <a href="{{ route('vendor.store.settings') }}" 
               class="nav-link text-white {{ request()->routeIs('vendor.store.*') ? 'active fw-bold' : '' }}">
                <i class="fas fa-store me-2"></i> Minha Loja
            </a>
        </li>
    </ul>
</div>


    <script src="{{ asset('js/app.js') }}"></script>
    @stack('scripts')
</body>
</html>
