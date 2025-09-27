@extends('layouts.marketplace')

@section('page-title', 'Finalizar Compra')
@section('page-subtitle', 'Preencha os dados e conclua sua encomenda')

@section('marketplace-content')
<div class="row">
    <!-- Formulário -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">
                Dados do Cliente
            </div>
            <div class="card-body">
                <form action="{{ route('checkout.process') }}" method="POST">
                    @csrf

                    <!-- Informações pessoais -->
                    <h5 class="fw-bold mb-3">Informações Pessoais</h5>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <x-form-input name="name" label="Nome Completo" required value="{{ old('name') }}" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-form-input type="email" name="email" label="E-mail" required value="{{ old('email') }}" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-form-input type="tel" name="phone" label="Telefone" required value="{{ old('phone') }}" />
                        </div>
                    </div>

                    <!-- Endereço -->
                    <h5 class="fw-bold mb-3 mt-4">Endereço de Entrega</h5>
                    <div class="row">
                        <div class="col-md-8 mb-3">
                            <x-form-input name="address" label="Endereço" required value="{{ old('address') }}" />
                        </div>
                        <div class="col-md-4 mb-3">
                            <x-form-input name="zip" label="Código Postal" value="{{ old('zip') }}" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-form-input name="city" label="Cidade" required value="{{ old('city') }}" />
                        </div>
                        <div class="col-md-6 mb-3">
                            <x-dropdown name="province" label="Província" :options="$provinces" selected="{{ old('province') }}" />
                        </div>
                    </div>

                    <!-- Pagamento -->
                    <h5 class="fw-bold mb-3 mt-4">Método de Pagamento</h5>
                    <div class="mb-3">
                        <x-dropdown 
                            name="payment_method" 
                            label="Selecione um método" 
                            :options="['card' => 'Cartão de Crédito/Débito', 'transfer' => 'Transferência Bancária', 'multicaixa' => 'Multicaixa']" 
                            selected="{{ old('payment_method') }}" 
                            required
                        />
                    </div>

                    <!-- Botão submit -->
                    <div class="mt-4">
                        <x-button type="submit" size="lg" variant="primary" icon="fas fa-check-circle">
                            Confirmar Pedido
                        </x-button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Resumo Final -->
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">
                Resumo da Compra
            </div>
            <div class="card-body">
                <!-- Itens do carrinho -->
                @foreach($cartItems as $item)
                    <div class="d-flex justify-content-between mb-2">
                        <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                        <span>{{ currency_format($item->total) }}</span>
                    </div>
                @endforeach
                <hr>
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>{{ currency_format($summary['subtotal']) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Taxas</span>
                    <span>{{ currency_format($summary['taxes']) }}</span>
                </div>
                <div class="d-flex justify-content-between fw-bold">
                    <span>Total</span>
                    <span>{{ currency_format($summary['total']) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
