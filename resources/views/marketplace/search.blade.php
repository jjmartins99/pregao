@extends('layouts.marketplace')

@section('page-title', 'Pesquisar Produtos')
@section('page-subtitle', 'Encontre o que procura no PREGÃO')

@section('marketplace-content')
<!-- Search Header -->
<div class="search-header mb-4">
    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
        <div>
            <h3 class="fw-bold mb-1">Resultados da Pesquisa</h3>
            <p class="text-muted mb-0">{{ $products->total() }} produtos encontrados</p>
        </div>
        <div class="search-box">
            <x-form-search 
                :action="route('marketplace.products.search')" 
                name="q" 
                placeholder="Procurar produtos..." 
                :value="request('q')" 
            />
        </div>
    </div>
</div>

<!-- Products Grid -->
<div class="row">
    @forelse($products as $product)
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <x-product-card :product="$product" />
        </div>
    @empty
        <div class="col-12">
            <x-empty-state 
                icon="fas fa-search"
                title="Nenhum produto encontrado"
                message="Não encontramos resultados para a sua pesquisa. Tente outros termos ou explore as categorias."
                button-text="Voltar ao Marketplace"
                :button-url="route('marketplace.index')"
            />
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($products->hasPages())
    <x-pagination :paginator="$products" />
@endif
@endsection
