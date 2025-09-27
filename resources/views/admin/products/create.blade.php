@extends('layouts.vendor')

@section('page-title', 'Novo Produto')
@section('page-subtitle', 'Adicione um novo item ao catálogo')

@section('vendor-content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <x-form-input name="name" label="Nome do Produto" required />
            <x-form-input name="price" type="number" step="0.01" label="Preço" required />
            <x-form-input name="stock" type="number" label="Stock" required />

            <div class="mb-3">
                <label class="form-label">Categoria</label>
                <select name="category_id" class="form-select">
                    <option value="">Selecione...</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            <x-form-input name="image" type="file" label="Imagem" />

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Produto</button>
        </form>
    </div>
</div>
@endsection
