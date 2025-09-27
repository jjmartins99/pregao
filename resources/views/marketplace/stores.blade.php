@extends('layouts.marketplace')

@section('page-title', 'Lojas')
@section('page-subtitle', 'Descubra as melhores lojas no PREGÃO')

@section('marketplace-content')
<!-- Stores Header -->
<div class="stores-header mb-4">
    <div class="d-flex justify-content-between align-items-center">
        <div>
            <h3 class="fw-bold">Lojas</h3>
            <p class="text-muted">{{ $stores->total() }} lojas encontradas</p>
        </div>
        <div class="view-options">
            <div class="btn-group" role="group">
                <x-button type="button" variant="outline" id="gridView" class="active">
                    <i class="fas fa-th"></i>
                </x-button>
                <x-button type="button" variant="outline" id="listView">
                    <i class="fas fa-list"></i>
                </x-button>
            </div>
        </div>
    </div>
</div>

<!-- Stores Grid -->
<div class="row" id="storesGrid">
    @forelse($stores as $store)
        <div class="col-xl-4 col-lg-6 col-md-6 mb-4">
            <x-store-card :store="$store" />
        </div>
    @empty
        <div class="col-12">
            <x-empty-state 
                icon="fas fa-store" 
                title="Nenhuma loja encontrada" 
                message="Ainda não existem lojas nesta categoria. Volte mais tarde ou explore outras opções."
                button-text="Voltar ao Início"
                :button-url="route('marketplace.index')"
            />
        </div>
    @endforelse
</div>

<!-- Pagination -->
@if($stores->hasPages())
    <x-pagination :paginator="$stores" />
@endif
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // View toggle
    const gridView = document.getElementById('gridView');
    const listView = document.getElementById('listView');
    const storesGrid = document.getElementById('storesGrid');
    
    gridView.addEventListener('click', function() {
        storesGrid.className = 'row';
        gridView.classList.add('active');
        listView.classList.remove('active');
    });
    
    listView.addEventListener('click', function() {
        storesGrid.className = 'row list-view';
        listView.classList.add('active');
        gridView.classList.remove('active');
    });
});
</script>

<style>
.list-view .col-md-6,
.list-view .col-lg-6,
.list-view .col-xl-4 {
    flex: 0 0 100%;
    max-width: 100%;
}
.list-view .store-card {
    flex-direction: row;
    height: auto;
}
.list-view .store-card .store-logo {
    width: 150px;
    height: 150px;
}
.list-view .store-card .card-body {
    flex: 1;
}
</style>
@endpush
