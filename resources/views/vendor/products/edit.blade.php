@extends('layouts.vendor')

@section('page-title', 'Editar Produto')
@section('page-subtitle', 'Atualize as informações do produto')

@section('vendor-content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('vendor.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-form-input name="name" label="Nome do Produto" :value="$product->name" required />
            <x-form-input name="description" label="Descrição" type="textarea" :value="$product->description" required />

            <div class="row">
                <div class="col-md-6">
                    <x-form-input name="price" label="Preço" type="number" step="0.01" :value="$product->price" required />
                </div>
                <div class="col-md-6">
                    <x-form-input name="stock" label="Stock" type="number" :value="$product->stock" required />
                </div>
            </div>

            <x-form-select name="category_id" label="Categoria" :options="$categories" :selected="$product->category_id" required />

            <div class="mb-3">
                <label class="form-label">Imagens do Produto</label>
                <input type="file" class="form-control" name="images[]" multiple>
                @if($product->images)
                    <div class="mt-2 d-flex flex-wrap gap-2">
                        @foreach($product->images as $img)
                            <img src="{{ asset('storage/'.$img) }}" class="img-thumbnail" width="100">
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="form-check form-switch mb-3">
                <input type="checkbox" class="form-check-input" id="status" name="status" {{ $product->status ? 'checked' : '' }}>
                <label class="form-check-label" for="status">Ativo</label>
            </div>

            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save me-1"></i> Atualizar Produto
            </button>
            <a href="{{ route('vendor.products.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
