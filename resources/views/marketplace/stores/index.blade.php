@extends('layouts.marketplace')

@section('page-title', 'Todas as Lojas')
@section('page-subtitle', 'Descubra as melhores lojas do PREGÃO')

@section('sidebar')
<div class="sidebar-sticky">
    <div class="card mb-4">
        <div class="card-header bg-white">
            <h6 class="mb-0">Filtrar Lojas</h6>
        </div>
        <div class="card-body">
            <form id="storeFilterForm">
                <!-- Verification -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Tipo de Loja</label>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="verified" id="verifiedOnly" 
                               {{ request('verified') ? 'checked' : '' }}>
                        <label class="form-check-label" for="verifiedOnly">Apenas verificadas</label>
                    </div>
                </div>

                <!-- Rating -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Avaliação Mínima</label>
                    <select class="form-select" name="min_rating">
                        <option value="">Qualquer avaliação</option>
                        <option value="4" {{ request('min_rating') == '4' ? 'selected' : '' }}>4+ estrelas</option>
                        <option value="3" {{ request('min_rating') == '3' ? 'selected' : '' }}>3+ estrelas</option>
                    </select>
                </div>

                <!-- Sort -->
                <div class="mb-3">
                    <label class="form-label fw-bold">Ordenar por</label>
                    <select class="form-select" name="sort">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Mais Recentes</option>
                        <option value="rating" {{ request('sort') == 'rating' ? 'selected' : '' }}>Melhor Avaliadas</option>
                        <option value="products" {{ request('sort') == 'products' ? 'selected' : '' }}>Mais Produtos</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary w-100">Aplicar Filtros</button>
                <button type="reset" class="btn btn-outline-secondary w-100 mt-2">Limpar</button>
            </form>
        </div>
    </div>

    <!-- Quick Stats -->
    <div class="card">
        <div class="card-body">
            <h6 class="card-title">Estatísticas</h6>
            <div class="store-stats">
                <div class="d-flex justify-content-between small mb-2">
                    <span>Total de Lojas:</span>
                    <span class="fw-bold">{{ $totalStores }}</span>
                </div>
                <div class="d-flex justify-content-between small mb-2">
                    <span>Lojas Verificadas:</span>
                    <span class="fw-bold">{{ $verifiedStores }}</span>
                </div>
                <div class="d-flex justify-content-between small">
                    <span>Produtos Totais:</span>
                    <span class="fw-bold">{{ $totalProducts }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('marketplace-content')
<!-- Stores Header -->
<div class="stores-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold">Todas as Lojas</h3>
            <p class="text-muted">{{ $stores->total() }} lojas encontradas</p>
        </div>
        <div>
            <a href="{{ route('stores.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-2"></i>Criar Minha Loja
            </a>
        </div>
    </div>
</div>

<!-- Search Box -->
<div class="row mb-4">
    <div class="col-12">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('stores.index') }}" method="GET">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Pesquisar lojas..." 
                               name="search" value="{{ request('search') }}">
                        <button class="btn btn-primary" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Stores Grid -->
<div class="row">
    @forelse($stores as $store)
    <div class="col-xl-4 col-lg-6 mb-4">
        @include('components.store-card', ['store' => $store])
    </div>
    @empty
    <div class="col-12">
        <div class="text-center py-5">
            <i class="fas fa-store-slash fa-4x text-muted mb-3"></i>
            <h4 class="text-muted">Nenhuma loja encontrada</h4>
            <p class="text-muted">Tente ajustar os filtros de pesquisa.</p>
            @auth
            <a href="{{ route('stores.create') }}" class="btn btn-primary">
                Criar Primeira Loja
            </a>
            @endauth
        </div>
    </div>
    @endforelse
</div>

<!-- Pagination -->
@if($stores->hasPages())
<div class="row mt-4">
    <div class="col-12">
        <nav aria-label="Page navigation">
            {{ $stores->appends(request()->query())->links() }}
        </nav>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Form submission
    document.getElementById('storeFilterForm').addEventListener('submit', function(e) {
        e.preventDefault();
        this.submit();
    });
});
</script>
@endpush