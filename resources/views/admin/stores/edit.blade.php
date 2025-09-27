@extends('layouts.app')

@section('page-title', "Editar Loja #{$store->id}")
@section('page-subtitle', $store->name)

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.stores.update', $store) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <x-form-input name="name" label="Nome da Loja" :value="$store->name" required />
            <x-form-input name="email" label="Email de Contacto" :value="$store->email" required />
            <x-form-input name="phone" label="Telefone" :value="$store->phone" />

            <x-form-input name="logo" type="file" label="Logo da Loja" />

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="description" class="form-control" rows="4">{{ $store->description }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" @selected($store->status === 'active')>Ativa</option>
                    <option value="inactive" @selected($store->status === 'inactive')>Inativa</option>
                </select>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" name="approved" value="1" 
                       id="approved" @checked($store->approved)>
                <label for="approved" class="form-check-label">Loja aprovada</label>
            </div>

            <button type="submit" class="btn btn-primary">Atualizar Loja</button>
        </form>
    </div>
</div>
@endsection
