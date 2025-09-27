@extends('layouts.app')

@section('page-title', 'Gestão de Utilizadores')
@section('page-subtitle', 'Administre os utilizadores, papéis e permissões')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Utilizadores</h5>
            <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
                <i class="fas fa-user-plus me-1"></i> Novo Utilizador
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Papéis</th>
                        <th>Status</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                        <tr>
                            <td>{{ $user->id }}</td>
                            <td>{{ $user->name }}</td>
                            <td>{{ $user->email }}</td>
                            <td>
                                @foreach($user->roles as $role)
                                    <span class="badge bg-info text-dark">{{ $role->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                <x-badge-status :status="$user->status" />
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="d-inline-block">
                                    @csrf
                                    <button type="submit" class="btn btn-sm {{ $user->status === 'active' ? 'btn-danger' : 'btn-success' }}">
                                        <i class="fas {{ $user->status === 'active' ? 'fa-ban' : 'fa-check' }}"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6">
                                <x-empty-state 
                                    icon="fas fa-users"
                                    title="Nenhum utilizador encontrado"
                                    message="Ainda não existem utilizadores registados."
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <x-pagination :paginator="$users" class="mt-3" />
    </div>
</div>
@endsection
