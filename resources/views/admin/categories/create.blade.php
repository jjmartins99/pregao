@extends('layouts.vendor')

@section('page-title', 'Nova Categoria')
@section('page-subtitle', 'Adicione uma nova categoria ao catálogo')

@section('vendor-content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.categories.store') }}" method="POST">
            @csrf

            <x-form-input name="name" label="Nome da Categoria" required />
            <x-form-input name="icon" label="Ícone (FontAwesome)" />

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="description" class="form-control" rows="3"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Categoria</button>
        </form>
    </div>
</div>
@endsection
