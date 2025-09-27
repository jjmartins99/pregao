@extends('layouts.vendor')

@section('page-title', "Pedido #{$order->id}")
@section('page-subtitle', "Detalhes e gestão deste pedido")

@section('vendor-content')
<div class="row">
    <div class="col-lg-8">

        <!-- Produtos -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Produtos</h6>
            </div>
            <div class="card-body">
                @foreach($order->items as $item)
                    <div class="mb-3">
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

        <!-- Resumo -->
        <div class="card shadow-sm">
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
    </div>

    <!-- Coluna lateral -->
    <div class="col-lg-4">

        <!-- Status do Pedido -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Status do Pedido</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.orders.update-status', $order->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label class="form-label">Estado</label>
                        <select class="form-select" name="status">
                            <option value="pending" @selected($order->status == 'pending')>Pendente</option>
                            <option value="processing" @selected($order->status == 'processing')>Em Processamento</option>
                            <option value="shipped" @selected($order->status == 'shipped')>Enviado</option>
                            <option value="delivered" @selected($order->status == 'delivered')>Entregue</option>
                            <option value="cancelled" @selected($order->status == 'cancelled')>Cancelado</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Atualizar</button>
                </form>
            </div>
        </div>

        <!-- Dados de Entrega -->
        <div class="card mb-4 shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Entrega</h6>
            </div>
            <div class="card-body">
                <p class="mb-1"><strong>Nome:</strong> {{ $order->shipping_name }}</p>
                <p class="mb-1"><strong>Endereço:</strong> {{ $order->shipping_address }}</p>
                <p class="mb-1"><strong>Telefone:</strong> {{ $order->shipping_phone }}</p>
                @if($order->shipping_notes)
                    <p class="small text-muted">Obs: {{ $order->shipping_notes }}</p>
                @endif
            </div>
        </div>

        <!-- Pagamento -->
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
