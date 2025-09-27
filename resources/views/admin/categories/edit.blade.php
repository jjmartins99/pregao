@extends('layouts.vendor')

@section('page-title', "Editar Categoria #{$category->id}")
@section('page-subtitle', $category->name)

@section('vendor-content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form-input name="name" label="Nome da Categoria" :value="$category->name" required />
            <x-form-input name="icon" label="Ícone (FontAwesome)" :value="$category->icon" />

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="description" class="form-control" rows="3">{{ $category->description }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar Categoria</button>
        </form>
    </div>
</div>
@endsection
