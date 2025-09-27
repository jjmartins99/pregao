@extends('layouts.vendor')

@section('page-title', 'Meus Produtos')
@section('page-subtitle', 'Gestão do catálogo da loja')

@section('vendor-content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h5>Produtos</h5>
    <a href="{{ route('vendor.products.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-1"></i> Novo Produto
    </a>
</div>

<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Produto</th>
                    <th>Preço</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->name }}</td>
                        <td>{{ currency_format($product->price) }}</td>
                        <td>{{ $product->stock }}</td>
                        <td><x-badge-status :status="$product->status" /></td>
                        <td class="text-end">
                            <a href="{{ route('vendor.products.edit', $product) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('vendor.products.destroy', $product) }}" method="POST" class="d-inline-block">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <x-empty-state 
                                icon="fas fa-boxes"
                                title="Nenhum produto"
                                message="Adicione produtos ao seu catálogo."
                            />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<x-pagination :paginator="$products" class="mt-3" />
@endsection
