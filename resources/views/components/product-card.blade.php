<div class="product-card card h-100 shadow-sm">
    <!-- Product Image -->
    <div class="product-image position-relative">
        <img src="{{ $product->images ? asset('storage/' . $product->images[0]) : asset('images/placeholder-product.png') }}" 
             class="card-img-top" alt="{{ $product->name }}" style="height: 200px; object-fit: cover;">
        
        <!-- Sale Badge -->
        @if($product->sale_price && $product->sale_price < $product->price)
        <span class="position-absolute top-0 start-0 badge bg-danger m-2">
            -{{ number_format((($product->price - $product->sale_price) / $product->price) * 100, 0) }}%
        </span>
        @endif
        
        <!-- Quick Actions -->
        <div class="product-actions position-absolute top-0 end-0 m-2">
            <button class="btn btn-sm btn-light rounded-circle" title="Adicionar à lista de desejos">
                <i class="fas fa-heart"></i>
            </button>
        </div>
    </div>

    <!-- Product Body -->
    <div class="card-body">
        <!-- Store Name -->
        <small class="text-muted d-block mb-1">{{ $product->store->name }}</small>
        
        <!-- Product Name -->
        <h6 class="card-title product-name">
            <a href="{{ route('marketplace.products.show', $product->slug) }}" class="text-decoration-none text-dark">
                {{ Str::limit($product->name, 50) }}
            </a>
        </h6>

        <!-- Rating -->
        <div class="product-rating mb-2">
            <div class="stars">
                @for($i = 1; $i <= 5; $i++)
                <i class="fas fa-star {{ $i <= $product->rating ? 'text-warning' : 'text-muted' }}"></i>
                @endfor
            </div>
            <small class="text-muted">({{ $product->reviews_count }})</small>
        </div>

        <!-- Price -->
        <div class="product-price mb-3">
            @if($product->sale_price && $product->sale_price < $product->price)
            <span class="current-price fw-bold text-primary h5">
                {{ number_format($product->sale_price, 2, ',', '.') }} Kz
            </span>
            <span class="original-price text-muted text-decoration-line-through ms-2">
                {{ number_format($product->price, 2, ',', '.') }} Kz
            </span>
            @else
            <span class="current-price fw-bold text-primary h5">
                {{ number_format($product->price, 2, ',', '.') }} Kz
            </span>
            @endif
        </div>

        <!-- Stock Status -->
        <div class="product-stock mb-3">
            @if($product->quantity > 10)
            <span class="badge bg-success">Em Stock</span>
            @elseif($product->quantity > 0)
            <span class="badge bg-warning text-dark">Últimas Unidades</span>
            @else
            <span class="badge bg-danger">Esgotado</span>
            @endif
        </div>
    </div>

    <!-- Card Footer -->
    <div class="card-footer bg-transparent border-top-0">
        <div class="d-grid gap-2">
            @if($product->quantity > 0)
            <button class="btn btn-primary add-to-cart-btn" 
                    data-product-id="{{ $product->id }}"
                    data-product-name="{{ $product->name }}"
                    data-product-price="{{ $product->sale_price ?? $product->price }}"
                    data-product-image="{{ $product->images ? asset('storage/' . $product->images[0]) : asset('images/placeholder-product.png') }}">
                <i class="fas fa-shopping-cart me-2"></i>Adicionar ao Carrinho
            </button>
            @else
            <button class="btn btn-outline-secondary" disabled>
                <i class="fas fa-bell me-2"></i>Notificar quando disponível
            </button>
            @endif
        </div>
    </div>
</div>