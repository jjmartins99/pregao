@extends('layouts.vendor')

@section('page-title', 'Novo Produto')
@section('page-subtitle', 'Adicione um produto ao catálogo da sua loja')

@section('vendor-content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('vendor.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <x-form-input name="name" label="Nome do Produto" required />
            <x-form-input name="description" label="Descrição" type="textarea" required />

            <div class="row">
                <div class="col-md-6">
                    <x-form-input name="price" label="Preço" type="number" step="0.01" required />
                </div>
                <div class="col-md-6">
                    <x-form-input name="stock" label="Stock" type="number" required />
                </div>
            </div>

            <x-form-select name="category_id" label="Categoria" :options="$categories" required />

            <div class="mb-3">
                <label class="form-label">Imagens do Produto</label>
                <input type="file" class="form-control" name="images[]" multiple>
                <small class="text-muted">Pode enviar várias imagens (jpg, png).</small>
            </div>

            <div class="form-check form-switch mb-3">
                <input type="checkbox" class="form-check-input" id="status" name="status" checked>
                <label class="form-check-label" for="status">Ativo</label>
            </div>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-1"></i> Guardar Produto
            </button>
            <a href="{{ route('vendor.products.index') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>
</div>
@endsection
