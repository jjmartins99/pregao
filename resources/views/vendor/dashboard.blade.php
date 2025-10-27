@extends('layouts.vendor')

@section('page-title', 'Dashboard')
@section('page-subtitle', 'Resumo da sua loja e desempenho')

@section('vendor-content')
<div class="row mb-4">
    <!-- Vendas Totais -->
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="fas fa-coins fa-2x text-primary mb-2"></i>
                <h5 class="fw-bold">Kz {{ number_format($stats['total_sales'], 2, ',', '.') }}</h5>
                <p class="text-muted small mb-0">Vendas Totais</p>
            </div>
        </div>
    </div>
    <!-- Encomendas Ativas -->
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="fas fa-shopping-cart fa-2x text-success mb-2"></i>
                <h5 class="fw-bold">{{ $stats['active_orders'] }}</h5>
                <p class="text-muted small mb-0">Encomendas Ativas</p>
            </div>
        </div>
    </div>
    <!-- Produtos em Stock -->
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="fas fa-boxes fa-2x text-warning mb-2"></i>
                <h5 class="fw-bold">{{ $stats['products_in_stock'] }}</h5>
                <p class="text-muted small mb-0">Produtos em Stock</p>
            </div>
        </div>
    </div>
    <!-- Receita Mensal -->
    <div class="col-md-3 mb-3">
        <div class="card shadow-sm h-100">
            <div class="card-body text-center">
                <i class="fas fa-chart-line fa-2x text-danger mb-2"></i>
                <h5 class="fw-bold">Kz {{ number_format($stats['monthly_revenue'], 2, ',', '.') }}</h5>
                <p class="text-muted small mb-0">Receita deste mês</p>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Últimas Encomendas -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Últimas Encomendas</h6>
                <a href="{{ route('vendor.orders.index') }}" class="btn btn-sm btn-outline-primary">Ver todas</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Cliente</th>
                            <th>Status</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($latestOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->customer->name }}</td>
                            <td>
                                <x-badge-status :status="$order->status" />
                            </td>
                            <td>Kz {{ number_format($order->total, 2, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center text-muted py-3">Nenhuma encomenda recente</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Produtos com Stock Baixo -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h6 class="mb-0">Produtos com Stock Baixo</h6>
                <a href="{{ route('vendor.products.index') }}" class="btn btn-sm btn-outline-primary">Gerir</a>
            </div>
            <div class="card-body p-0">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Produto</th>
                            <th>Stock</th>
                            <th>Preço</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($lowStockProducts as $product)
                        <tr>
                            <td>{{ $product->name }}</td>
                            <td><span class="badge bg-warning text-dark">{{ $product->stock }}</span></td>
                            <td>Kz {{ number_format($product->price, 2, ',', '.') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="3" class="text-center text-muted py-3">Nenhum produto com stock baixo</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <!-- Vendas Semanais -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Evolução Semanal de Vendas</h6>
            </div>
            <div class="card-body">
                <canvas id="weeklySalesChart" height="150"></canvas>
            </div>
        </div>
    </div>

    <!-- Vendas Mensais -->
    <div class="col-lg-6 mb-4">
        <div class="card shadow-sm">
            <div class="card-header bg-white">
                <h6 class="mb-0">Evolução Mensal de Vendas</h6>
            </div>
            <div class="card-body">
                <canvas id="monthlySalesChart" height="150"></canvas>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    // Dados do backend (passados via controller)
    const weeklySales = @json($charts['weekly_sales']); 
    const monthlySales = @json($charts['monthly_sales']);

    // Gráfico Semanal
    new Chart(document.getElementById('weeklySalesChart'), {
        type: 'line',
        data: {
            labels: weeklySales.labels, // ['Seg', 'Ter', ...]
            datasets: [{
                label: 'Vendas (Kz)',
                data: weeklySales.data,   // [1200, 1500, ...]
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13,110,253,0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });

    // Gráfico Mensal
    new Chart(document.getElementById('monthlySalesChart'), {
        type: 'bar',
        data: {
            labels: monthlySales.labels, // ['Jan', 'Fev', ...]
            datasets: [{
                label: 'Vendas (Kz)',
                data: monthlySales.data,   // [15000, 20000, ...]
                backgroundColor: 'rgba(25,135,84,0.6)',
                borderColor: '#198754',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false }
            },
            scales: {
                y: { beginAtZero: true }
            }
        }
    });
});
</script>
@endpush
