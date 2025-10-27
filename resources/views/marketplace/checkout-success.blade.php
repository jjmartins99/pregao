@extends('layouts.marketplace')

@section('page-title', 'Pedido Confirmado')
@section('page-subtitle', 'Obrigado pela sua compra!')

@section('marketplace-content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm text-center p-4">
            <div class="mb-4 text-success">
                <i class="fas fa-check-circle fa-4x"></i>
            </div>
            <h3 class="fw-bold mb-3">Pedido realizado com sucesso!</h3>
            <p class="text-muted mb-4">
                O seu pedido <span class="fw-bold">#{{ $order->id }}</span> foi confirmado.  
                Enviaremos os detalhes para o seu e-mail <span class="fw-bold">{{ $order->customer_email }}</span>.
            </p>

            <!-- Resumo breve -->
            <div class="mb-4">
                <h5 class="fw-bold">Resumo do Pedido</h5>
                <ul class="list-group list-group-flush text-start">
                    @foreach($order->items as $item)
                        <li class="list-group-item d-flex justify-content-between">
                            <span>{{ $item->product->name }} (x{{ $item->quantity }})</span>
                            <span>{{ currency_format($item->total) }}</span>
                        </li>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between fw-bold">
                        <span>Total Pago</span>
                        <span>{{ currency_format($order->total) }}</span>
                    </li>
                </ul>
            </div>

            <!-- Ações -->
            <div class="d-flex justify-content-center gap-3">
                <x-button :url="route('marketplace.index')" variant="primary" icon="fas fa-store">
                    Continuar a Comprar
                </x-button>

                <x-button :url="route('orders.show', $order->id)" variant="secondary" icon="fas fa-file-invoice">
                    Ver Detalhes do Pedido
                </x-button>
            </div>
        </div>
    </div>
</div>
@endsection
