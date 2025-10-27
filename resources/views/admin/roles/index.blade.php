@extends('layouts.app')

@section('page-title', 'Gestão de Papéis')
@section('page-subtitle', 'Crie e atribua papéis para controlar permissões')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-3">
            <h5>Papéis</h5>
            <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                <i class="fas fa-plus me-1"></i> Novo Papel
            </a>
        </div>

        <table class="table table-striped align-middle">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Permissões</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                    <tr>
                        <td>{{ $role->id }}</td>
                        <td>{{ $role->name }}</td>
                        <td>
                            @foreach($role->permissions as $perm)
                                <span class="badge bg-secondary">{{ $perm->name }}</span>
                            @endforeach
                        </td>
                        <td class="text-end">
                            <a href="{{ route('admin.roles.edit', $role) }}" class="btn btn-sm btn-warning">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">
                            <x-empty-state 
                                icon="fas fa-shield-alt"
                                title="Nenhum papel definido"
                                message="Crie papéis para organizar permissões no sistema."
                            />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
