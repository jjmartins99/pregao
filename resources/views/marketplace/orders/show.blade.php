@extends('layouts.marketplace')

@section('title', 'Detalhes do Pedido')

@section('content')
<div class="container py-4">
    <h3 class="mb-4">Pedido #{{ $order->id }}</h3>

    <!-- Info do Pedido -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Data do Pedido</h6>
                    <p>{{ $order->created_at->format('d/m/Y H:i') }}</p>

                    <h6 class="text-muted">Status</h6>
                    <p>
                        <span class="badge bg-{{ $order->status_color }}">
                            {{ ucfirst($order->status) }}
                        </span>
                    </p>

                    <h6 class="text-muted">Método de Pagamento</h6>
                    <p>{{ ucfirst($order->payment_method) }}</p>
                </div>
            </div>
        </div>

        <!-- Endereço -->
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h6 class="text-muted">Endereço de Entrega</h6>
                    <p>
                        {{ $order->address }} <br>
                        Tel: {{ $order->phone }} <br>
                        Email: {{ $order->email }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Itens do Pedido -->
    <div class="card shadow-sm mb-4">
        <div class="card-header">Itens do Pedido</div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produto</th>
                            <th>Preço</th>
                            <th>Qtd</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $item->product->image_url ?? asset('images/product-placeholder.png') }}"
                                             alt="{{ $item->product->name }}"
                                             class="me-2 rounded"
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                        <span>{{ $item->product->name }}</span>
                                    </div>
                                </td>
                                <td>{{ number_format($item->price, 2, ',', '.') }} Kz</td>
                                <td>{{ $item->quantity }}</td>
                                <td>{{ number_format($item->total, 2, ',', '.') }} Kz</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Total -->
    <div class="d-flex justify-content-end">
        <div class="card shadow-sm" style="max-width: 300px;">
            <div class="card-body">
                <h5 class="d-flex justify-content-between">
                    <span>Total:</span>
                    <span class="text-primary">{{ number_format($order->total, 2, ',', '.') }} Kz</span>
                </h5>
            </div>
        </div>
    </div>
</div>
@endsection
