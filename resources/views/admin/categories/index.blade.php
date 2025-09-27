@extends('layouts.vendor')

@section('page-title', 'Gestão de Categorias')
@section('page-subtitle', 'Organize o catálogo de forma eficiente')

@section('vendor-content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Categorias</h5>
            <a href="{{ route('admin.categories.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Nova Categoria
            </a>
        </div>

        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Descrição</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($categories as $cat)
                    <tr>
                        <td>{{ $cat->id }}</td>
                        <td>{{ $cat->name }}</td>
                        <td>{{ $cat->description }}</td>
                        <td class="text-end">
                            <a href="{{ route('admin.categories.edit', $cat) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST" 
                                  class="d-inline-block" onsubmit="return confirm('Eliminar categoria?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <x-empty-state 
                                title="Nenhuma categoria criada"
                                description="Ainda não existem categorias definidas."
                            />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
