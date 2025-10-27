@extends('layouts.marketplace')

@section('page-title', 'Criar Nova Loja')
@section('page-subtitle', 'Comece a vender no PREGÃO')

@section('marketplace-content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h4 class="card-title mb-0">Criar Nova Loja</h4>
            </div>
            <div class="card-body">
                <form action="{{ route('stores.store') }}" method="POST" enctype="multipart/form-data" id="createStoreForm">
                    @csrf

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Nome da Loja *</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       name="name" value="{{ old('name') }}" required>
                                @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Categoria Principal *</label>
                                <select class="form-select @error('category_id') is-invalid @enderror" name="category_id" required>
                                    <option value="">Selecione uma categoria</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @error('category_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Descrição da Loja *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  name="description" rows="4" required>{{ old('description') }}</textarea>
                        <small class="text-muted">Descreva os produtos e serviços que oferece (mín. 100 caracteres)</small>
                        @error('description')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Email de Contacto *</label>
                                <input type="email" class="form-control @error('contact_email') is-invalid @enderror" 
                                       name="contact_email" value="{{ old('contact_email', Auth::user()->email) }}" required>
                                @error('contact_email')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Telefone de Contacto *</label>
                                <input type="tel" class="form-control @error('contact_phone') is-invalid @enderror" 
                                       name="contact_phone" value="{{ old('contact_phone') }}" required>
                                @error('contact_phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Endereço</label>
                        <textarea class="form-control @error('address') is-invalid @enderror" 
                                  name="address" rows="2">{{ old('address') }}</textarea>
                        @error('address')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Logo da Loja</label>
                                <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                       name="logo" accept="image/*">
                                <small class="text-muted">Recomendado: 300x300px, formato PNG ou JPG</small>
                                @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label class="form-label">Banner da Loja</label>
                                <input type="file" class="form-control @error('banner') is-invalid @enderror" 
                                       name="banner" accept="image/*">
                                <small class="text-muted">Recomendado: 1200x300px, formato PNG ou JPG</small>
                                @error('banner')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <div class="mb-4">
                        <div class="form-check">
                            <input class="form-check-input @error('terms') is-invalid @enderror" 
                                   type="checkbox" name="terms" id="terms" required>
                            <label class="form-check-label" for="terms">
                                Concordo com os <a href="#" target="_blank">Termos de Serviço</a> e 
                                <a href="#" target="_blank">Política de Vendas</a> do PREGÃO
                            </label>
                            @error('terms')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-store me-2"></i>Criar Loja
                        </button>
                        <a href="{{ route('stores.index') }}" class="btn btn-outline-secondary">
                            Cancelar
                        </a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Help Section -->
        <div class="card mt-4">
            <div class="card-header">
                <h5 class="card-title mb-0">Como funciona?</h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            <i class="fas fa-user-check fa-3x text-primary mb-3"></i>
                            <h6>Verificação</h6>
                            <p class="small text-muted">Sua loja será verificada em até 48h</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            <i class="fas fa-percentage fa-3x text-primary mb-3"></i>
                            <h6>Comissões</h6>
                            <p class="small text-muted">Apenas 5% de comissão por venda</p>
                        </div>
                    </div>
                    <div class="col-md-4 mb-3">
                        <div class="text-center">
                            <i class="fas fa-headset fa-3x text-primary mb-3"></i>
                            <h6>Suporte</h6>
                            <p class="small text-muted">Equipa de suporte disponível 24/7</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('createStoreForm');
    
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Basic validation
        const name = form.elements['name'].value.trim();
        const description = form.elements['description'].value.trim();
        
        if (name.length < 3) {
            alert('O nome da loja deve ter pelo menos 3 caracteres');
            return;
        }
        
        if (description.length < 100) {
            alert('A descrição deve ter pelo menos 100 caracteres');
            return;
        }
        
        this.submit();
    });
});
</script>
@endpush