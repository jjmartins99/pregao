@extends('layouts.marketplace')

@section('page-title', 'Carrinho de Compras')
@section('page-subtitle', 'Revise os produtos antes de finalizar a compra')

@section('marketplace-content')
<div class="row">
    <!-- Lista de Produtos -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">
                Produtos no Carrinho
            </div>
            <div class="card-body">
                @forelse($cartItems as $item)
                    <div class="mb-3 pb-3 border-bottom">
                        <x-product-card :product="$item->product" compact>
                            <!-- Extra controls no carrinho -->
                            <div class="d-flex align-items-center mt-3">
                                <form action="{{ route('cart.update', $item->id) }}" method="POST" class="d-flex align-items-center me-3">
                                    @csrf
                                    @method('PUT')
                                    <input type="number" name="quantity" min="1" value="{{ $item->quantity }}" 
                                           class="form-control form-control-sm me-2" style="width: 70px;">
                                    <x-button type="submit" size="sm" variant="outline" icon="fas fa-sync">
                                        Atualizar
                                    </x-button>
                                </form>
                                <form action="{{ route('cart.remove', $item->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <x-button type="submit" size="sm" variant="danger" icon="fas fa-trash">
                                        Remover
                                    </x-button>
                                </form>
                            </div>
                        </x-product-card>
                    </div>
                @empty
                    <x-empty-state 
                        icon="fas fa-shopping-cart"
                        title="Seu carrinho está vazio"
                        message="Adicione produtos ao carrinho para continuar a compra."
                        button-text="Explorar Produtos"
                        :button-url="route('marketplace.index')"
                    />
                @endforelse
            </div>
        </div>
    </div>

    <!-- Resumo -->
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white fw-bold">
                Resumo da Compra
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between mb-2">
                    <span>Subtotal</span>
                    <span>{{ currency_format($summary['subtotal']) }}</span>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span>Taxas</span>
                    <span>{{ currency_format($summary['taxes']) }}</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold mb-4">
                    <span>Total</span>
                    <span>{{ currency_format($summary['total']) }}</span>
                </div>

                <x-button type="primary" size="lg" url="{{ route('checkout.index') }}" icon="fas fa-credit-card" class="w-100 mb-2">
                    Finalizar Compra
                </x-button>
                <x-button type="outline" size="lg" url="{{ route('marketplace.index') }}" icon="fas fa-arrow-left" class="w-100">
                    Continuar Comprando
                </x-button>
            </div>
        </div>
    </div>
</div>
@endsection
