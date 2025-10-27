@extends('layouts.marketplace')

@section('title', $product->name)

@section('content')
<div class="container py-4">
    <div class="row">
        <!-- Galeria -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <img src="{{ $product->image_url ?? asset('images/product-placeholder.png') }}" 
                     alt="{{ $product->name }}" 
                     class="card-img-top">
            </div>
        </div>

        <!-- Detalhes -->
        <div class="col-md-6 mb-4">
            <h2>{{ $product->name }}</h2>
            <p class="text-muted">{{ $product->brand }}</p>
            <h3 class="text-primary mb-3">{{ number_format($product->price, 2, ',', '.') }} Kz</h3>

            <p>{{ $product->description }}</p>

            <div class="mb-3">
                <strong>Categoria:</strong> {{ $product->category->name }}
            </div>
            <div class="mb-3">
                <strong>Loja:</strong> <a href="{{ route('stores.show', $product->store) }}">
                    {{ $product->store->name }}
                </a>
            </div>

            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                @csrf
                <div class="input-group mb-3" style="max-width: 200px;">
                    <input type="number" name="quantity" class="form-control" value="1" min="1">
                    <button class="btn btn-primary" type="submit">Adicionar ao Carrinho</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Produtos Relacionados -->
    <div class="row mt-5">
        <h4 class="mb-3">Produtos Relacionados</h4>
        @foreach($relatedProducts as $related)
            <div class="col-md-3 mb-4">
                @include('components.product-card', ['product' => $related])
            </div>
        @endforeach
    </div>
</div>
@endsection
