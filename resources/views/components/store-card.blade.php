<div class="store-card card h-100 shadow-sm">
    <!-- Store Header -->
    <div class="store-header position-relative">
        <!-- Cover Image -->
        <img src="{{ $store->banner ? asset('storage/' . $store->banner) : asset('images/store-banner.jpg') }}" 
             class="card-img-top" alt="{{ $store->name }}" style="height: 120px; object-fit: cover;">
        
        <!-- Store Logo -->
        <div class="store-logo position-absolute top-100 start-50 translate-middle">
            <img src="{{ $store->logo ? asset('storage/' . $store->logo) : asset('images/store-logo.png') }}" 
                 alt="{{ $store->name }}" class="rounded-circle border border-4 border-white" 
                 style="width: 80px; height: 80px; object-fit: cover;">
        </div>
    </div>

    <!-- Store Body -->
    <div class="card-body text-center mt-4">
        <!-- Store Name -->
        <h5 class="card-title">
            <a href="{{ route('stores.show', $store->slug) }}" class="text-decoration-none text-dark">
                {{ $store->name }}
            </a>
        </h5>

        <!-- Verification Badge -->
        @if($store->is_verified)
        <span class="badge bg-success mb-2">
            <i class="fas fa-check-circle me-1"></i>Verificado
        </span>
        @endif

        <!-- Rating -->
        <div class="store-rating mb-2">
            <div class="stars">
                @for($i = 1; $i <= 5; $i++)
                <i class="fas fa-star {{ $i <= floor($store->rating) ? 'text-warning' : 'text-muted' }}"></i>
                @endfor
            </div>
            <small class="text-muted">({{ $store->total_ratings }})</small>
        </div>

        <!-- Store Description -->
        <p class="card-text text-muted small">
            {{ Str::limit($store->description, 100) }}
        </p>

        <!-- Store Stats -->
        <div class="store-stats row text-center mb-3">
            <div class="col-4">
                <div class="stat-number fw-bold">{{ $store->products_count }}</div>
                <div class="stat-label text-muted small">Produtos</div>
            </div>
            <div class="col-4">
                <div class="stat-number fw-bold">{{ $store->sales_count }}</div>
                <div class="stat-label text-muted small">Vendas</div>
            </div>
            <div class="col-4">
                <div class="stat-number fw-bold">{{ $store->followers_count }}</div>
                <div class="stat-label text-muted small">Seguidores</div>
            </div>
        </div>
    </div>

    <!-- Card Footer -->
    <div class="card-footer bg-transparent">
        <div class="d-grid gap-2">
            <a href="{{ route('stores.show', $store->slug) }}" class="btn btn-outline-primary">
                <i class="fas fa-store me-2"></i>Visitar Loja
            </a>
        </div>
    </div>
</div>