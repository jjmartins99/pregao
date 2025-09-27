@extends('layouts.app')

@section('page-title', 'Novo Utilizador')
@section('page-subtitle', 'Criar um novo utilizador no sistema')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <x-form-input name="name" label="Nome" required />
            <x-form-input name="email" label="Email" type="email" required />
            <x-form-input name="password" label="Senha" type="password" required />
            <x-form-input name="password_confirmation" label="Confirmar Senha" type="password" required />

            <div class="mb-3">
                <label class="form-label">Papéis</label>
                <select name="roles[]" class="form-select" multiple required>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                    @endforeach
                </select>
                <div class="form-text">Segure CTRL (ou CMD no Mac) para selecionar múltiplos papéis</div>
            </div>

            <button type="submit" class="btn btn-primary">Criar Utilizador</button>
        </form>
    </div>
</div>
@endsection
