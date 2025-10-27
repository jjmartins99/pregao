@extends('layouts.vendor')

@section('title', 'Meus Produtos')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Produtos da Loja</h2>
        <a href="{{ route('seller.products.create') }}" class="btn btn-primary">+ Novo Produto</a>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <table class="table align-middle">
                <thead>
                    <tr>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Stock</th>
                        <th>Categoria</th>
                        <th>Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products ?? [] as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td>{{ number_format($product->price, 2, ',', '.') }} Kz</td>
                            <td>{{ $product->stock }}</td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td>
                                <a href="{{ route('seller.products.edit', $product->id) }}" class="btn btn-sm btn-warning">Editar</a>
                                <form method="POST" action="{{ route('seller.products.destroy', $product->id) }}" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-sm btn-danger" onclick="return confirm('Eliminar produto?')">Apagar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="text-center">Nenhum produto registado.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
