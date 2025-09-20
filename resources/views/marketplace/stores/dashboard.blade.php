@extends('layouts.vendor')

@section('page-title', 'Dashboard da Loja')
@section('page-subtitle', 'Visão geral do seu negócio')

@section('vendor-content')
<div class="row">
    <!-- Stats Overview -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start border-primary border-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted fw-semibold">Vendas Hoje</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['today_sales'] }}</h3>
                        <small class="text-success">
                            <i class="fas fa-arrow-up me-1"></i>{{ $stats['sales_growth'] }}% desde ontem
                        </small>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-shopping-cart fa-2x text-primary"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start border-success border-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted fw-semibold">Receita Total</h6>
                        <h3 class="fw-bold mb-0">{{ number_format($stats['total_revenue'], 2, ',', '.') }} Kz</h3>
                        <small class="text-success">
                            <i class="fas fa-arrow-up me-1"></i>{{ $stats['revenue_growth'] }}% este mês
                        </small>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-money-bill-wave fa-2x text-success"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start border-info border-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted fw-semibold">Total de Pedidos</h6>
                        <h3 class="fw-bold mb-0">{{ $stats['total_orders'] }}</h3>
                        <small class="text-success">
                            <i class="fas fa-arrow-up me-1"></i>{{ $stats['order_growth'] }}% este mês
                        </small>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-clipboard-list fa-2x text-info"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-start border-warning border-4 shadow-sm">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1">
                        <h6 class="text-muted fw-semibold">Avaliação Média</h6>
                        <h3 class="fw-bold mb-0">{{ number_format($stats['average_rating'], 1) }}/5</h3>
                        <small class="text-success">
                            <i class="fas fa-star me-1"></i>{{ $stats['total_reviews'] }} avaliações
                        </small>
                    </div>
                    <div class="flex-shrink-0">
                        <i class="fas fa-star fa-2x text-warning"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Revenue Chart -->
    <div class="col-xl-8 mb-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="card-title mb-0">Desempenho de Vendas (Últimos 30 dias)</h6>
            </div>
            <div class="card-body">
                <canvas id="revenueChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <!-- Quick Actions -->
    <div class="col-xl-4 mb-4">
        <div class="card shadow-sm">
            <div class="card-header">
                <h6 class="card-title mb-0">Acções Rápidas</h6>
            </div>
            <div class="card-body">
                <div class="d-grid gap-2">
                    <a href="{{ route('products.create') }}" class="btn btn-primary">
                        <i class="fas fa-plus me-2"></i>Adicionar Produto
                    </a>
                    <a href="{{ route('orders.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-clipboard-list me-2"></i>Ver Pedidos
                    </a>
                    <a href="{{ route('stores.edit', $store->slug) }}" class="btn btn-outline-secondary">
                        <i class="fas fa-cog me-2"></i>Configurações da Loja
                    </a>
                    <a href="{{ route('stores.analytics') }}" class="btn btn-outline-info">
                        <i class="fas fa-chart-line me-2"></i>Relatórios
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Orders -->
    <div class="col-xl-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">Pedidos Recentes</h6>
                <a href="{{ route('orders.index') }}" class="btn btn-sm btn-outline-primary">Ver Todos</a>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Pedido</th>
                                <th>Cliente</th>
                                <th>Total</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($recentOrders as $order)
                            <tr>
                                <td>#{{ $order->order_number }}</td>
                                <td>{{ $order->customer->name }}</td>
                                <td>{{ number_format($order->total, 2, ',', '.') }} Kz</td>
                                <td>
                                    <span class="badge bg-{{ $order->status_color }}">
                                        {{ $order->status_label }}
                                    </span>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="4" class="text-center text-muted py-3">
                                    Nenhum pedido recente
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Top Products -->

    <!-- Top Products -->
    <div class="col-xl-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h6 class="card-title mb-0">Produtos Mais Vendidos</h6>
                <a href="{{ route('products.index') }}" class="btn btn-sm btn-outline-primary">Gerir Produtos</a>
            </div>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    @forelse($topProducts as $product)
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <img src="{{ $product->image_url ?? asset('images/product-placeholder.png') }}" 
                                 alt="{{ $product->name }}" class="rounded me-3" 
                                 style="width: 40px; height: 40px; object-fit: cover;">
                            <span>{{ $product->name }}</span>
                        </div>
                        <span class="badge bg-success">{{ $product->sales_count }} vendas</span>
                    </li>
                    @empty
                    <li class="list-group-item text-center text-muted">
                        Nenhum produto ainda registado
                    </li>
                    @endforelse
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ctx = document.getElementById('revenueChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($chartData['labels']),
            datasets: [{
                label: 'Receita (Kz)',
                data: @json($chartData['values']),
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,0.1)',
                tension: 0.3,
                fill: true,
                pointBackgroundColor: '#0d6efd'
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return value + ' Kz';
                        }
                    }
                }
            }
        }
    });
});
</script>
@endpush