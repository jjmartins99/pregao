@extends('layouts.marketplace')

@section('title', 'Registo de Lojista')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-7">
            <div class="card shadow-sm">
                <div class="card-body p-4">
                    <h3 class="mb-4 text-center">Criar Conta de Lojista</h3>

                    <form method="POST" action="{{ route('register.seller') }}">
                        @csrf

                        <!-- Nome da Loja -->
                        <div class="mb-3">
                            <label for="store_name" class="form-label">Nome da Loja</label>
                            <input type="text" id="store_name" name="store_name"
                                   class="form-control @error('store_name') is-invalid @enderror"
                                   value="{{ old('store_name') }}" required>
                            @error('store_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Nome do Responsável -->
                        <div class="mb-3">
                            <label for="owner_name" class="form-label">Nome do Responsável</label>
                            <input type="text" id="owner_name" name="owner_name"
                                   class="form-control @error('owner_name') is-invalid @enderror"
                                   value="{{ old('owner_name') }}" required>
                            @error('owner_name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">E-mail</label>
                            <input type="email" id="email" name="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   value="{{ old('email') }}" required>
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Telefone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefone</label>
                            <input type="text" id="phone" name="phone"
                                   class="form-control @error('phone') is-invalid @enderror"
                                   value="{{ old('phone') }}" required>
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- NIF -->
                        <div class="mb-3">
                            <label for="nif" class="form-label">NIF</label>
                            <input type="text" id="nif" name="nif"
                                   class="form-control @error('nif') is-invalid @enderror"
                                   value="{{ old('nif') }}" required>
                            @error('nif')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Senha</label>
                            <input type="password" id="password" name="password"
                                   class="form-control @error('password') is-invalid @enderror"
                                   required>
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">Confirmar Senha</label>
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="form-control" required>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-warning">Criar Conta de Lojista</button>
                        </div>
                    </form>

                    <div class="mt-3 text-center">
                        <small>Já é lojista? <a href="{{ route('login') }}">Entrar</a></small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
