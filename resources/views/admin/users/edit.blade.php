@extends('layouts.app')

@section('page-title', "Editar Utilizador #{$user->id}")
@section('page-subtitle', $user->name)

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <x-form-input name="name" label="Nome" :value="$user->name" required />
            <x-form-input name="email" label="Email" type="email" :value="$user->email" required />

            <x-form-input name="password" label="Nova Senha (opcional)" type="password" />
            <x-form-input name="password_confirmation" label="Confirmar Nova Senha" type="password" />

            <div class="mb-3">
                <label class="form-label">Papéis</label>
                <select name="roles[]" class="form-select" multiple required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}" 
                                @selected($user->roles->contains($role->id))>
                            {{ $role->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar Utilizador</button>
        </form>
    </div>
</div>
@endsection
