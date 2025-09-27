@extends('layouts.vendor')

@section('page-title', 'Gestão de Pedidos')
@section('page-subtitle', 'Acompanhe e administre todos os pedidos dos clientes')

@section('vendor-content')
<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h5 class="mb-0">Pedidos</h5>
            <form method="GET" class="d-flex">
                <x-form-search name="search" placeholder="Buscar por cliente ou nº pedido" :value="request('search')" />
            </form>
        </div>

        <div class="table-responsive">
            <table class="table table-striped align-middle">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Cliente</th>
                        <th>Data</th>
                        <th>Total</th>
                        <th>Status</th>
                        <th>Pagamento</th>
                        <th class="text-end">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td>#{{ $order->id }}</td>
                            <td>{{ $order->shipping_name }}</td>
                            <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                            <td>{{ currency_format($order->total) }}</td>
                            <td><x-badge-status :status="$order->status" /></td>
                            <td>{{ ucfirst($order->payment_status) }}</td>
                            <td class="text-end">
                                <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-sm btn-primary">
                                    <i class="fas fa-eye me-1"></i> Ver
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <x-empty-state 
                                    title="Nenhum pedido encontrado"
                                    description="Ainda não existem pedidos registados ou a sua pesquisa não encontrou resultados."
                                />
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-3">
            <x-pagination :paginator="$orders" />
        </div>
    </div>
</div>
@endsection
