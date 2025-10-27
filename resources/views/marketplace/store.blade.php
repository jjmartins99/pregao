@extends('layouts.marketplace')

@section('page-title', $store->name)
@section('page-subtitle', Str::limit($store->description, 120))

@section('marketplace-content')
<!-- Store Header -->
<div class="store-header mb-5">
    <div class="card shadow-sm">
        <div class="card-body d-flex align-items-center">
            <!-- Logo -->
            <div class="me-4 text-center">
                <img src="{{ $store->logo_url ?? asset('images/store-placeholder.png') }}"
                     alt="{{ $store->name }}"
                     class="rounded-circle border"
                     style="width:120px; height:120px; object-fit:cover;">
            </div>

            <!-- Store Info -->
            <div class="flex-grow-1">
                <h2 class="fw-bold mb-1">{{ $store->name }}</h2>
                <p class="text-muted mb-2">{{ $store->description }}</p>

                <!-- Status + Rating -->
                <div class="d-flex align-items-center gap-3">
                    <x-status-badge :status="$store->status" />
                    <x-rating-stars :rating="$store->average_rating" />
                    <span class="small text-muted">({{ $store->reviews_count }} avaliações)</span>
                </div>
            </div>

            <!-- CTA -->
            <div>
                <x-button type="primary" url="{{ route('stores.contact', $store->slug) }}" icon="fas fa-envelope">
                    Contactar Loja
                </x-button>
            </div>
        </div>
    </div>
</div>

<!-- Store Stats -->
<div class="row mb-5 text-center">
    <div class="col-md-3 col-6 mb-3">
        <h4 class="fw-bold text-primary">{{ $products->total() }}</h4>
        <p class="text-muted small mb-0">Produtos</p>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <h4 class="fw-bold text-primary">{{ $store->followers_count }}</h4>
        <p class="text-muted small mb-0">Seguidores</p>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <h4 class="fw-bold text-primary">{{ $store->orders_count }}</h4>
        <p="text-muted small mb-0">Pedidos Concluídos</p>
    </div>
    <div class="col-md-3 col-6 mb-3">
        <h4 class="fw-bold text-primary">{{ $store->years_active }}</h4>
        <p class="text-muted small mb-0">Anos no PREGÃO</p>
    </div>
</div>

<!-- Store Products -->
<div class="store-products">
    <h3 class="fw-bold mb-4">Produtos desta Loja</h3>

    <div class="row">
        @forelse($products as $product)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <x-product-card :product="$product" />
            </div>
        @empty
            <div class="col-12">
                <x-empty-state 
                    icon="fas fa-box-open" 
                    title="Nenhum produto disponível"
                    message="Esta loja ainda não publicou produtos. Volte em breve ou explore outras lojas."
                    button-text="Explorar Lojas"
                    :button-url="route('stores.index')"
                />
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($products->hasPages())
        <x-pagination :paginator="$products" />
    @endif
</div>
@endsection
