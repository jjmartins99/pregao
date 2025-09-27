@extends('layouts.vendor')

@section('page-title', 'Gestão de Produtos')
@section('page-subtitle', 'Administre o catálogo da sua loja')

@section('vendor-content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Produtos</h5>
            <a href="{{ route('admin.products.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Novo Produto
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Imagem</th>
                        <th>Nome</th>
                        <th>Categoria</th>
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
                            <td>
                                <img src="{{ $product->image_url }}" alt="{{ $product->name }}" 
                                     class="rounded" width="50">
                            </td>
                            <td>{{ $product->name }}</td>
                            <td>{{ $product->category->name ?? '-' }}</td>
                            <td>{{ currency_format($product->price) }}</td>
                            <td>{{ $product->stock }}</td>
                            <td><x-badge-status :status="$product->status" /></td>
                            <td class="text-end">
                                <a href="{{ route('admin.products.edit', $product) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" 
                                      class="d-inline-block" onsubmit="return confirm('Eliminar produto?')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8">
                                <x-empty-state 
                                    title="Nenhum produto encontrado"
                                    description="Ainda não adicionou nenhum produto ao catálogo."
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-pagination :paginator="$products" class="mt-3" />
    </div>
</div>
@endsection
