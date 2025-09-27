@extends('layouts.marketplace')

@section('page-title', $category->name)
@section('page-subtitle', $category->description)

@section('sidebar')
<div class="sidebar-sticky">
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0">Filtros</h6>
        </div>
        <div class="card-body">
            <form id="filterForm">
                <!-- Price Range -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Preço</label>
                    <div class="row g-2">
                        <div class="col-6">
                            <input type="number" class="form-control" placeholder="Mín" name="min_price" 
                                   value="{{ request('min_price') }}">
                        </div>
                        <div class="col-6">
                            <input type="number" class="form-control" placeholder="Máx" name="max_price" 
                                   value="{{ request('max_price') }}">
                        </div>
                    </div>
                </div>

                <!-- Sort -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Ordenar por</label>
                    <select class="form-select" name="sort">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mais Recentes</option>
                        <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Preço: Menor para Maior</option>
                        <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Preço: Maior para Menor</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Melhor Avaliados</option>
                    </select>
                </div>

                <!-- Availability -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Disponibilidade</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="in_stock" id="inStock" 
                               {{ request('in_stock') ? 'checked' : '' }}>
                        <label class="form-check-label" for="inStock">Apenas em stock</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-primary w-100">Aplicar Filtros</button>
                <button type="reset" class="btn btn-outline-secondary w-100 mt-2">Limpar</button>
            </form>
        </div>
    </div>

    <!-- Category Info -->
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Sobre esta Categoria</h6>
            <p class="small text-muted">{{ $category->description }}</p>
            <div class="category-stats">
                <div class="d-flex justify-content-between small">
                    <span>Total de Produtos:</span>
                    <span class="fw-bold">{{ $products->total() }}</span>
                </div>
                <div class="d-flex justify-content-between small">
                    <span>Lojas:</span>
                    <span class="fw-bold">{{ $storesCount }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('marketplace-content')
<!-- Category Header -->
<div class="category-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold">{{ $category->name }}</h3>
            <p class="text-muted">{{ $products->total() }} produtos encontrados</p>
        </div>
        <div class="view-options">
            <div class="btn-group" role="group">
                <button type="button" class="btn btn-outline-secondary active" id="gridView">
                    <i class="fas fa-th"></i>
                </button>
                <button type="button" class="btn btn-outline-secondary" id="listView">
                    <i class="fas fa-list"></i>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Products Grid -->
<div class="row" id="productsGrid">
    @forelse($products as $product)
    <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
        @include('components.product-card', ['product' => $product])
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5">
            <i class="fas fa-search fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Nenhum produto encontrado</h4>
            <p class="text-muted">Tente ajustar os filtros ou explore outras categorias.</p>
            <a href="{{ route('marketplace.index') }}" class="btn btn-primary">
                Voltar ao Início
            </a>
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($products->hasPages())
<div class="row mt-4">
    <div class="col-12">
        <nav aria-label="Page navigation">
            {{ $products->appends(request()->query())->links() }}
        </nav>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // View toggle
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const productsGrid = document.getElementById('productsGrid');
    
    gridView.addEventListener('click', function() {
        productsGrid.className = 'row';
        gridView.classList.add('active');
        listView.classList.remove('active');
    });
    
    listView.addEventListener('click', function() {
        productsGrid.className = 'row list-view';
        listView.classList.add('active');
        gridView.classList.remove('active');
    });

    // Form submission
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        this.submit();
    });
});
</script>

<style>
.list-view .col-md-6 {
    flex: 0 0 100%;
    max-width: 100%;
}
.list-view .product-card {
    flex-direction: row;
    height: auto;
}
.list-view .product-card .product-image {
    width: 200px;
    height: 200px;
}
.list-view .product-card .card-body {
    flex: 1;
}
</style>
@endpush