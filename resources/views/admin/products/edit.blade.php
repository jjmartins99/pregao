@extends('layouts.vendor')

@section('page-title', "Editar Produto #{$product->id}")
@section('page-subtitle', $product->name)

@section('vendor-content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-form-input name="name" label="Nome do Produto" :value="$product->name" required />
            <x-form-input name="price" type="number" step="0.01" label="Preço" :value="$product->price" required />
            <x-form-input name="stock" type="number" label="Stock" :value="$product->stock" required />

            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <select name="category_id" class="form-select">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" @selected($product->category_id == $cat->id)>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <x-form-input name="image" type="file" label="Imagem" />

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="description" class="form-control" rows="4">{{ $product->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar Produto</button>
        </form>
    </div>
</div>
@endsection
