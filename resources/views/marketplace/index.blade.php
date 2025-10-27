@extends('layouts.marketplace')

@section('page-title', 'PREGÃO Marketplace')
@section('page-subtitle', 'Encontre os melhores produtos e serviços em Angola')

@section('marketplace-content')
    <!-- Hero Section -->
    <section class="hero-section mb-5">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <h2 class="display-4 fw-bold mb-4">Bem-vindo ao PREGÃO</h2>
                <p class="lead mb-4">
                    O maior marketplace angolano, conectando empresas, lojistas e clientes em uma plataforma completa.
                </p>
                <div class="hero-buttons d-flex gap-3">
                    <x-button type="primary" size="lg" url="{{ route('stores.index') }}" icon="fas fa-store">
                        Explorar Lojas
                    </x-button>

                    <x-button type="outline" size="lg" url="#featured-products" icon="fas fa-shopping-bag">
                        Ver Produtos
                    </x-button>
                </div>
            </div>
            <div class="col-lg-6">
                <img src="{{ asset('images/marketplace-hero.png') }}" 
                     alt="Marketplace PREGÃO" 
                     class="img-fluid">
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Categorias Populares</h3>
            <x-button type="outline" url="{{ route('marketplace.categories') }}">
                Ver Todas <i class="fas fa-arrow-right ms-2"></i>
            </x-button>
        </div>
        
        <div class="row">
            @foreach($featuredCategories as $category)
                <div class="col-md-3 col-6 mb-4">
                    <x-card class="h-100 text-center">
                        <div class="mb-3">
                            <i class="fas {{ $category->icon }} fa-3x text-primary"></i>
                        </div>
                        <h5 class="fw-bold">{{ $category->name }}</h5>
                        <p class="text-muted small">{{ $category->products_count }} produtos</p>

                        <x-button type="outline" size="sm" url="{{ route('marketplace.category', $category->slug) }}">
                            Explorar
                        </x-button>
                    </x-card>
                </div>
            @endforeach
        </div>
    </section>

    <!-- Featured Products Section -->
    <section id="featured-products" class="featured-products-section mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Produtos em Destaque</h3>
            <x-button type="outline" url="{{ route('marketplace.products.search') }}">
                Ver Todos <i class="fas fa-arrow-right ms-2"></i>
            </x-button>
        </div>
        
        <div class="row">
            @forelse($featuredProducts as $product)
                <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                    <x-product-card :product="$product" />
                </div>
            @empty
                <x-empty-state 
                    title="Nenhum produto encontrado"
                    description="Ainda não existem produtos em destaque."
                    icon="fas fa-box-open"
                />
            @endforelse
        </div>
    </section>

    <!-- Featured Stores Section -->
    <section class="featured-stores-section mb-5">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Lojas em Destaque</h3>
            <x-button type="outline" url="{{ route('stores.index') }}">
                Ver Todas <i class="fas fa-arrow-right ms-2"></i>
            </x-button>
        </div>
        
        <div class="row">
            @forelse($featuredStores as $store)
                <div class="col-xl-4 col-md-6 mb-4">
                    <x-store-card :store="$store" />
                </div>
            @empty
                <x-empty-state 
                    title="Nenhuma loja encontrada"
                    description="Ainda não existem lojas em destaque."
                    icon="fas fa-store-slash"
                />
            @endforelse
        </div>
    </section>

    <!-- Stats Section -->
    <section class="stats-section bg-light py-5 mb-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <x-card class="stat-item border-0 bg-light shadow-none">
                        <h2 class="display-4 fw-bold text-primary">{{ $stats['total_products'] }}+</h2>
                        <p class="text-muted">Produtos</p>
                    </x-card>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <x-card class="stat-item border-0 bg-light shadow-none">
                        <h2 class="display-4 fw-bold text-primary">{{ $stats['total_stores'] }}+</h2>
                        <p class="text-muted">Lojas</p>
                    </x-card>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <x-card class="stat-item border-0 bg-light shadow-none">
                        <h2 class="display-4 fw-bold text-primary">{{ $stats['total_orders'] }}+</h2>
                        <p class="text-muted">Pedidos</p>
                    </x-card>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <x-card class="stat-item border-0 bg-light shadow-none">
                        <h2 class="display-4 fw-bold text-primary">{{ $stats['satisfied_customers'] }}+</h2>
                        <p class="text-muted">Clientes Satisfeitos</p>
                    </x-card>
                </div>
            </div>
        </div>
    </section>
@endsection
