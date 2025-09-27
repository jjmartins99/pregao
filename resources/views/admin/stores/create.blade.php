@extends('layouts.app')

@section('page-title', 'Nova Loja')
@section('page-subtitle', 'Registar uma nova loja no marketplace')

@section('content')
<div class="card shadow-sm">
    <div class="card-body">
        <form action="{{ route('admin.stores.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <x-form-input name="name" label="Nome da Loja" required />
            <x-form-input name="email" label="Email de Contacto" required />
            <x-form-input name="phone" label="Telefone" />

            <x-form-input name="logo" type="file" label="Logo da Loja" />

            <div class="mb-3">
                <label class="form-label">Descrição</label>
                <textarea name="description" class="form-control" rows="4"></textarea>
            </div>

            <div class="form-check mb-3">
                <input type="checkbox" class="form-check-input" name="approved" value="1" id="approved">
                <label for="approved" class="form-check-label">Aprovar imediatamente</label>
            </div>

            <button type="submit" class="btn btn-primary">Guardar Loja</button>
        </form>
    </div>
</div>
@endsection
