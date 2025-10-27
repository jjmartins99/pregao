@extends('layouts.vendor')

@section('title', 'Perfil da Loja')

@section('content')
<div class="container py-4">
    <h2 class="mb-3">Perfil da Loja</h2>

    <div class="card shadow-sm">
        <div class="card-body">
            <form method="POST" action="{{ route('seller.profile.update') }}">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="store_name" class="form-label">Nome da Loja</label>
                    <input type="text" id="store_name" name="store_name"
                           value="{{ old('store_name', $store->name ?? '') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">E-mail</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email', $store->email ?? '') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="phone" class="form-label">Telefone</label>
                    <input type="text" id="phone" name="phone"
                           value="{{ old('phone', $store->phone ?? '') }}" class="form-control">
                </div>

                <div class="mb-3">
                    <label for="address" class="form-label">Endereço</label>
                    <textarea id="address" name="address" class="form-control">{{ old('address', $store->address ?? '') }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Guardar Alterações</button>
            </form>
        </div>
    </div>
</div>
@endsection
