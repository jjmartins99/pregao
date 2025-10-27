@extends('layouts.marketplace')

@section('page-title', $store->name)
@section('page-subtitle', $store->description)

@section('marketplace-content')
<!-- Store Header -->
<div class="store-header mb-5">
    <div class="row align-items-center">
        <div class="col-md-8">
            <div class="d-flex align-items-center">
                <img src="{{ $store->logo ? asset('storage/' . $store->logo) : asset('images/store-logo.png') }}" 
                     alt="{{ $store->name }}" class="store-logo-large rounded-circle me-4" 
                     style="width: 100px; height: 100px; object-fit: cover;">
                <div>
                    <h1 class="fw-bold">{{ $store->name }}</h1>
                    <div class="store-meta">
                        <div class="store-rating mb-2">
                            <div class="stars d-inline-block">
                                @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= floor($store->rating) ? 'text-warning' : 'text-muted' }}"></i>
                                @endfor
                            </div>
                            <span class="ms-2">({{ $store->total_ratings }} avaliações)</span>
                        </div>
                        <div class="store-stats">
                            <span class="badge bg-light text-dark me-2">
                                <i class="fas fa-box me-1"></i>{{ $store->products_count }} produtos
                            </span>
                            <span class="badge bg-light text-dark me-2">
                                <i class="fas fa-users me-1"></i>{{ $store->followers_count }} seguidores
                            </span>
                            <span class="badge bg-light text-dark">
                                <i class="fas fa-check-circle me-1"></i>{{ $store->sales_count }} vendas
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-4 text-md-end">
            <div class="store-actions">
                @auth
                <button class="btn btn-outline-primary me-2" id="followStoreBtn"
                        data-store-id="{{ $store->id }}"
                        data-is-following="{{ $isFollowing ? 'true' : 'false' }}">
                    <i class="fas {{ $isFollowing ? 'fa-user-check' : 'fa-user-plus' }} me-1"></i>
                    {{ $isFollowing ? 'Seguindo' : 'Seguir' }}
                </button>
                @endauth
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contactStoreModal">
                    <i class="fas fa-envelope me-1"></i>Contactar
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Store Navigation -->
<div class="store-navigation mb-4">
    <ul class="nav nav-tabs" id="storeTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="products-tab" data-bs-toggle="tab" 
                    data-bs-target="#products" type="button" role="tab">
                Produtos ({{ $products->total() }})
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="about-tab" data-bs-toggle="tab" 
                    data-bs-target="#about" type="button" role="tab">
                Sobre a Loja
            </button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" 
                    data-bs-target="#reviews" type="button" role="tab">
                Avaliações ({{ $reviews->total() }})
            </button>
        </li>
    </ul>
</div>

<!-- Store Content -->
<div class="tab-content" id="storeTabContent">
    <!-- Products Tab -->
    <div class="tab-pane fade show active" id="products" role="tabpanel">
        <div class="row mb-4">
            <div class="col-md-6">
                <h5>Produtos da Loja</h5>
            </div>
            <div class="col-md-6">
                <div class="d-flex justify-content-end">
                    <select class="form-select form-select-sm w-auto" id="productSort">
                        <option value="newest">Mais Recentes</option>
                        <option value="price_asc">Preço: Menor para Maior</option>
                        <option value="price_desc">Preço: Maior para Menor</option>
                        <option value="popular">Mais Populares</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="row">
            @forelse($products as $product)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                @include('components.product-card', ['product' => $product])
            </div>
            @empty
            <div class="col-12">
                <div class="text-center py-5">
                    <i class="fas fa-box-open fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Esta loja ainda não tem produtos</h5>
                    <p class="text-muted">Volte mais tarde para ver novidades.</p>
                </div>
            </div>
            @endforelse
        </div>

        @if($products->hasPages())
        <div class="row mt-4">
            <div class="col-12">
                {{ $products->appends(request()->query())->links() }}
            </div>
        </div>
        @endif
    </div>

    <!-- About Tab -->
    <div class="tab-pane fade" id="about" role="tabpanel">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Sobre a Loja</h5>
                    </div>
                    <div class="card-body">
                        <p>{{ $store->description }}</p>
                        
                        <div class="store-details mt-4">
                            <h6 class="mb-3">Informações de Contacto</h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <p><strong><i class="fas fa-envelope me-2"></i>Email:</strong><br>
                                    {{ $store->contact_email }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><strong><i class="fas fa-phone me-2"></i>Telefone:</strong><br>
                                    {{ $store->contact_phone }}</p>
                                </div>
                            </div>
                            
                            @if($store->address)
                            <div class="mt-3">
                                <p><strong><i class="fas fa-map-marker-alt me-2"></i>Endereço:</strong><br>
                                {{ $store->address }}</p>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Estatísticas</h5>
                    </div>
                    <div class="card-body">
                        <div class="store-stats-detailed">
                            <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                                <span>Membro desde</span>
                                <strong>{{ $store->created_at->format('d/m/Y') }}</strong>
                            </div>
                            <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                                <span>Total de Produtos</span>
                                <strong>{{ $store->products_count }}</strong>
                            </div>
                            <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                                <span>Vendas Realizadas</span>
                                <strong>{{ $store->sales_count }}</strong>
                            </div>
                            <div class="stat-item d-flex justify-content-between align-items-center mb-3">
                                <span>Taxa de Resposta</span>
                                <strong>98%</strong>
                            </div>
                            <div class="stat-item d-flex justify-content-between align-items-center">
                                <span>Tempo de Resposta</span>
                                <strong>< 24h</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Reviews Tab -->
    <div class="tab-pane fade" id="reviews" role="tabpanel">
        <div class="row">
            <div class="col-lg-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Avaliações dos Clientes</h5>
                    </div>
                    <div class="card-body">
                        @forelse($reviews as $review)
                        <div class="review-item border-bottom pb-3 mb-3">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <div>
                                    <h6 class="mb-1">{{ $review->user->name }}</h6>
                                    <div class="stars">
                                        @for($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star {{ $i <= $review->rating ? 'text-warning' : 'text-muted' }}"></i>
                                        @endfor
                                    </div>
                                </div>
                                <small class="text-muted">{{ $review->created_at->format('d/m/Y') }}</small>
                            </div>
                            <p class="mb-2">{{ $review->comment }}</p>
                            @if($review->response)
                            <div class="store-response bg-light p-3 rounded">
                                <strong>Resposta da loja:</strong>
                                <p class="mb-0">{{ $review->response }}</p>
                            </div>
                            @endif
                        </div>
                        @empty
                        <div class="text-center py-4">
                            <i class="fas fa-comments fa-3x text-muted mb-3"></i>
                            <p class="text-muted">Esta loja ainda não tem avaliações.</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                @if($reviews->hasPages())
                <div class="mt-4">
                    {{ $reviews->links() }}
                </div>
                @endif
            </div>
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Deixe sua Avaliação</h5>
                    </div>
                    <div class="card-body">
                        @auth
                        <form action="{{ route('stores.reviews.store', $store->id) }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label class="form-label">Sua Avaliação</label>
                                <div class="rating-stars">
                                    @for($i = 5; $i >= 1; $i--)
                                    <input type="radio" id="star{{ $i }}" name="rating" value="{{ $i }}" 
                                           {{ $i == 5 ? 'checked' : '' }}>
                                    <label for="star{{ $i }}"><i class="fas fa-star"></i></label>
                                    @endfor
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Comentário</label>
                                <textarea class="form-control" name="comment" rows="4" 
                                          placeholder="Partilhe a sua experiência..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary w-100">Enviar Avaliação</button>
                        </form>
                        @else
                        <div class="text-center">
                            <p class="text-muted">Precisa estar logado para deixar uma avaliação.</p>
                            <a href="{{ route('login') }}" class="btn btn-primary">Fazer Login</a>
                        </div>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Contact Store Modal -->
<div class="modal fade" id="contactStoreModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Contactar {{ $store->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('stores.contact', $store->id) }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Assunto</label>
                        <input type="text" class="form-control" name="subject" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Mensagem</label>
                        <textarea class="form-control" name="message" rows="5" required></textarea>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Enviar Mensagem</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Follow store functionality
    const followBtn = document.getElementById('followStoreBtn');
    if (followBtn) {
        followBtn.addEventListener('click', function() {
            const storeId = this.dataset.storeId;
            const isFollowing = this.dataset.isFollowing === 'true';
            
            fetch(`/stores/${storeId}/follow`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    _method: isFollowing ? 'DELETE' : 'POST'
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    this.dataset.isFollowing = !isFollowing;
                    this.innerHTML = isFollowing ? 
                        '<i class="fas fa-user-plus me-1"></i>Seguir' : 
                        '<i class="fas fa-user-check me-1"></i>Seguindo';
                }
            });
        });
    }

    // Product sorting
    const productSort = document.getElementById('productSort');
    if (productSort) {
        productSort.addEventListener('change', function() {
            const url = new URL(window.location.href);
            url.searchParams.set('sort', this.value);
            window.location.href = url.toString();
        });
    }
});
</script>

<style>
.rating-stars {
    display: flex;
    flex-direction: row-reverse;
    justify-content: flex-end;
}

.rating-stars input {
    display: none;
}

.rating-stars label {
    cursor: pointer;
    color: #ddd;
    font-size: 1.5rem;
    padding: 0 2px;
}

.rating-stars input:checked ~ label {
    color: #ffc107;
}

.rating-stars label:hover,
.rating-stars label:hover ~ label {
    color: #ffc107;
}
</style>
@endpush