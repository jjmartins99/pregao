@extends('layouts.marketplace')

@section('page-title', 'Meus Pedidos')
@section('page-subtitle', 'Acompanhe o histórico e o estado das suas encomendas')

@section('marketplace-content')
<div class="row justify-content-center">
    <div class="col-lg-10">

        @if($orders->isEmpty())
            <x-empty-state 
                icon="fas fa-box-open"
                title="Nenhum pedido encontrado"
                message="Ainda não realizou compras no marketplace. Explore os produtos e faça já a sua primeira encomenda."
            >
                <x-button :url="route('marketplace.index')" variant="primary" icon="fas fa-store">
                    Ir às Compras
                </x-button>
            </x-empty-state>
        @else
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th># Pedido</th>
                                    <th>Data</th>
                                    <th>Estado</th>
                                    <th>Total</th>
                                    <th class="text-end">Ações</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                <tr>
                                    <td class="fw-bold">#{{ $order->id }}</td>
                                    <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                                    <td>
                                        <x-badge-status :status="$order->status" />
                                    </td>
                                    <td>{{ currency_format($order->total) }}</td>
                                    <td class="text-end">
                                        <x-button :url="route('orders.show', $order->id)" 
                                                  size="sm" 
                                                  variant="secondary" 
                                                  icon="fas fa-eye">
                                            Detalhes
                                        </x-button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                @if($orders->hasPages())
                    <div class="card-footer">
                        <x-pagination :paginator="$orders" />
                    </div>
                @endif
            </div>
        @endif

    </div>
</div>
@endsection
