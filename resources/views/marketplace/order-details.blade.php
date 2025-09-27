@extends('layouts.marketplace')

@section('page-title', "Pedido #{$order->id}")
@section('page-subtitle', "Detalhes da sua encomenda realizada em " . $order->created_at->format('d/m/Y H:i'))

@section('marketplace-content')
<div class="row justify-content-center">
    <div class="col-lg-10">

        <!-- Cabeçalho do Pedido -->
        <div class="card mb-4 shadow-sm">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <h5 class="mb-1">Pedido #{{ $order->id }}</h5>
                    <p class="text-muted mb-0">Realizado em {{ $order->created_at->format('d/m/Y H:i') }}</p>
                </div>
                <div>
                    <x-badge-status :status="$order->status" />
                </div>
            </div>
        </div>

        <!-- Lista de Produtos -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Produtos</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    @foreach($order->items as $item)
                        <div class="col-12 mb-3">
                            <x-product-card :product="$item->product" mode="compact">
                                <div class="d-flex justify-content-between small text-muted mt-2">
                                    <span>Qtd: {{ $item->quantity }}</span>
                                    <span>{{ currency_format($item->total) }}</span>
                                </div>
                            </x-product-card>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Resumo do Pedido -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Resumo</h6>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <span>Subtotal:</span>
                    <span>{{ currency_format($order->subtotal) }}</span>
                </div>
                <div class="d-flex justify-content-between">
                    <span>Entrega:</span>
                    <span>{{ currency_format($order->shipping_cost) }}</span>
                </div>
                <div class="d-flex justify-content-between fw-bold border-top pt-2 mt-2">
                    <span>Total:</span>
                    <span>{{ currency_format($order->total) }}</span>
                </div>
            </div>
        </div>

        <!-- Dados de Entrega -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Dados de Entrega</h6>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Nome:</strong> {{ $order->shipping_name }}</p>
                <p class="mb-1"><strong>Endereço:</strong> {{ $order->shipping_address }}</p>
                <p class="mb-1"><strong>Telefone:</strong> {{ $order->shipping_phone }}</p>
                @if($order->shipping_notes)
                    <p class="text-muted small">Observações: {{ $order->shipping_notes }}</p>
                @endif
            </div>
        </div>

        <!-- Dados de Pagamento -->
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Pagamento</h6>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Método:</strong> {{ ucfirst($order->payment_method) }}</p>
                <p class="mb-1"><strong>Status:</strong> {{ ucfirst($order->payment_status) }}</p>
                @if($order->payment_reference)
                    <p class="mb-0"><strong>Referência:</strong> {{ $order->payment_reference }}</p>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
