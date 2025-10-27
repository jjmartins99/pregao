@extends('layouts.marketplace')

@section('page-title', 'PREGÃO Marketplace')
@section('page-subtitle', 'Encontre os melhores produtos e serviços em Angola')

@section('marketplace-content')
<!-- Hero Section -->
<section class="hero-section mb-5">
    <div class="row align-items-center">
        <div class="col-lg-6">
            <h2 class="display-4 fw-bold mb-4">Bem-vindo ao PREGÃO</h2>
            <p class="lead mb-4">O maior marketplace angolano, conectando empresas, lojistas e clientes em uma plataforma completa.</p>
            <div class="hero-buttons">
                <a href="{{ route('stores.index') }}" class="btn btn-primary btn-lg me-3">
                    <i class="fas fa-store me-2"></i>Explorar Lojas
                </a>
                <a href="#featured-products" class="btn btn-outline-primary btn-lg">
                    <i class="fas fa-shopping-bag me-2"></i>Ver Produtos
                </a>
            </div>
    </div>
        <div class="col-lg-6">
            <img src="{{ asset('images/marketplace-hero.png') }}" alt="Marketplace PREGÃO" class="img-fluid">
        </div>
    </div>
</section>

<!-- Categories Section -->
<section class="categories-section mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Categorias Populares</h3>
        <a href="{{ route('marketplace.categories') }}" class="btn btn-outline-primary">
            Ver Todas <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
    
    <div class="row">
        @foreach($featuredCategories as $category)
        <div class="col-md-3 col-6 mb-4">
            <div class="category-card card h-100 shadow-sm">
                <div class="card-body text-center">
                    <div class="category-icon mb-3">
                        <i class="fas {{ $category->icon }} fa-3x text-primary"></i>
                    </div>
                    <h5 class="card-title">{{ $category->name }}</h5>
                    <p class="text-muted small">{{ $category->products_count }} produtos</p>
                    <a href="{{ route('marketplace.category', $category->slug) }}" 
                       class="btn btn-sm btn-outline-primary">Explorar</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</section>

<!-- Featured Products Section -->
<section id="featured-products" class="featured-products-section mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Produtos em Destaque</h3>
        <a href="{{ route('marketplace.products.search') }}" class="btn btn-outline-primary">
            Ver Todos <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
    
    <div class="row">
        @foreach($featuredProducts as $product)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            @include('components.product-card', ['product' => $product])
        </div>
        @endforeach
    </div>
</section>

<!-- Featured Stores Section -->
<section class="featured-stores-section mb-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold">Lojas em Destaque</h3>
        <a href="{{ route('stores.index') }}" class="btn btn-outline-primary">
            Ver Todas <i class="fas fa-arrow-right ms-2"></i>
        </a>
    </div>
    
    <div class="row">
        @foreach($featuredStores as $store)
        <div class="col-xl-4 col-md-6 mb-4">
            @include('components.store-card', ['store' => $store])
        </div>
        @endforeach
    </div>
</section>

<!-- Stats Section -->
<section class="stats-section bg-light py-5 mb-5">
    <div class="container">
        <div class="row text-center">
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-item">
                    <h2 class="display-4 fw-bold text-primary">{{ $stats['total_products'] }}+</h2>
                    <p class="text-muted">Produtos</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-item">
                    <h2 class="display-4 fw-bold text-primary">{{ $stats['total_stores'] }}+</h2>
                    <p class="text-muted">Lojas</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-item">
                    <h2 class="display-4 fw-bold text-primary">{{ $stats['total_orders'] }}+</h2>
                    <p class="text-muted">Pedidos</p>
                </div>
            </div>
            <div class="col-md-3 col-6 mb-4">
                <div class="stat-item">
                    <h2 class="display-4 fw-bold text-primary">{{ $stats['satisfied_customers'] }}+</h2>
                    <p class="text-muted">Clientes Satisfeitos</p>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection