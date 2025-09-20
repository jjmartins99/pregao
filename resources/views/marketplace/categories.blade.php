@extends('layouts.marketplace')

@section('page-title', 'Todas as Categorias')
@section('page-subtitle', 'Explore todas as categorias disponíveis no PREGÃO')

@section('marketplace-content')
<div class="row">
    <div class="col-12">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold">Todas as Categorias</h3>
            <div class="search-box">
                <input type="text" class="form-control" placeholder="Pesquisar categorias..." id="categorySearch">
            </div>
        </div>
    </div>
</div>

<div class="row" id="categoriesContainer">
    @foreach($categories as $category)
    <div class="col-md-4 col-lg-3 mb-4 category-item">
        <div class="category-card card h-100 shadow-sm">
            <div class="card-body text-center">
                <div class="category-icon mb-3">
                    <i class="fas {{ $category->icon }} fa-3x text-primary"></i>
                </div>
                <h5 class="card-title">{{ $category->name }}</h5>
                <p class="text-muted small">{{ $category->products_count }} produtos disponíveis</p>
                <div class="category-actions">
                    <a href="{{ route('marketplace.category', $category->slug) }}" 
                       class="btn btn-primary btn-sm">
                        Explorar Categoria
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@if($categories->isEmpty())
<div class="text-center py-5">
    <i class="fas fa-folder-open fa-4x text-muted mb-3"></i>
    <h4 class="text-muted">Nenhuma categoria encontrada</h4>
    <p class="text-muted">Ainda não há categorias disponíveis no marketplace.</p>
</div>
@endif

<div class="row mt-4">
    <div class="col-12">
        {{ $categories->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('categorySearch');
    const categoryItems = document.querySelectorAll('.category-item');
    
    searchInput.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        
        categoryItems.forEach(item => {
            const categoryName = item.querySelector('.card-title').textContent.toLowerCase();
            if (categoryName.includes(searchTerm)) {
                item.style.display = 'block';
            } else {
                item.style.display = 'none';
            }
        });
    });
});
</script>
@endpush