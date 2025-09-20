@extends('layouts.marketplace')

@section('title', 'Comparar Produtos')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Comparação de Produtos</h3>

    @if(count($products) >= 2)
    <div class="table-responsive">
        <table class="table table-bordered align-middle text-center">
            <thead class="table-light">
                <tr>
                    <th>Atributo</th>
                    @foreach($products as $product)
                        <th>{{ $product->name }}</th>
                    @endforeach
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Imagem</td>
                    @foreach($products as $product)
                        <td>
                            <img src="{{ $product->image_url ?? asset('images/product-placeholder.png') }}" 
                                 alt="{{ $product->name }}" 
                                 style="max-width: 120px;">
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Preço</td>
                    @foreach($products as $product)
                        <td class="fw-bold text-primary">{{ number_format($product->price, 2, ',', '.') }} Kz</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Categoria</td>
                    @foreach($products as $product)
                        <td>{{ $product->category->name }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td>Loja</td>
                    @foreach($products as $product)
                        <td>
                            <a href="{{ route('stores.show', $product->store) }}">
                                {{ $product->store->name }}
                            </a>
                        </td>
                    @endforeach
                </tr>
                <tr>
                    <td>Descrição</td>
                    @foreach($products as $product)
                        <td>{{ Str::limit($product->description, 120) }}</td>
                    @endforeach
                </tr>
                <tr>
                    <td></td>
                    @foreach($products as $product)
                        <td>
                            <a href="{{ route('products.show', $product) }}" class="btn btn-outline-primary btn-sm">
                                Ver Produto
                            </a>
                        </td>
                    @endforeach
                </tr>
            </tbody>
        </table>
    </div>
    @else
        <div class="alert alert-info">Selecione pelo menos 2 produtos para comparar.</div>
    @endif
</div>
@endsection
