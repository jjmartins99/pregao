@props(['store'])

<div class="card h-100 shadow-sm store-card">
    {{-- Logo da loja --}}
    <div class="card-img-top text-center p-3">
        <a href="{{ route('stores.show', $store->slug) }}">
            <img src="{{ $store->logo_url ?? asset('images/store-placeholder.png') }}" 
                 alt="{{ $store->name }}" 
                 class="img-fluid rounded-circle" 
                 style="width: 100px; height: 100px; object-fit: cover;">
        </a>
    </div>

    {{-- Corpo --}}
    <div class="card-body text-center">
        <h5 class="card-title mb-1">
            <a href="{{ route('stores.show', $store->slug) }}" class="text-decoration-none fw-bold">
                {{ $store->name }}
            </a>
        </h5>
        <p class="text-muted small mb-2">
            {{ Str::limit($store->description, 80) }}
        </p>

        {{-- Status da loja --}}
        <x-status-badge :status="$store->status" class="mb-2" />

        {{-- Botão visitar --}}
        <div class="mt-3">
            <x-button type="outline" size="sm" url="{{ route('stores.show', $store->slug) }}" icon="fas fa-store">
                Visitar Loja
            </x-button>
        </div>
    </div>
</div>
