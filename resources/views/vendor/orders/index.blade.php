@extends('layouts.vendor')

@section('page-title', 'Pedidos da Minha Loja')
@section('page-subtitle', 'Acompanhe os pedidos recebidos')

@section('vendor-content')
<div class="card shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped align-middle mb-0">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Cliente</th>
                    <th>Total</th>
                    <th>Status</th>
                    <th>Data</th>
                    <th class="text-end">Ações</th>
                </tr>
            </thead>
            <tbody>
                @forelse($orders as $order)
                    <tr>
                        <td>{{ $order->id }}</td>
                        <td>{{ $order->customer_name }}</td>
                        <td>{{ currency_format($order->total) }}</td>
                        <td><x-badge-status :status="$order->status" /></td>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="text-end">
                            <a href="{{ route('vendor.orders.show', $order) }}" class="btn btn-sm btn-info">
                                <i class="fas fa-eye"></i>
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">
                            <x-empty-state 
                                icon="fas fa-receipt"
                                title="Sem pedidos"
                                message="Os pedidos recebidos aparecerão aqui."
                            />
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<x-pagination :paginator="$orders" class="mt-3" />
@endsection
