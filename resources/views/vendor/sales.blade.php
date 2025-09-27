@extends('layouts.vendor')

@section('title', 'Vendas - Dashboard Lojista')

@section('content')
<div class="row">
    <!-- Card do gráfico -->
    <div class="col-12 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-0">
                <h5 class="mb-0 fw-bold">📈 Evolução das Vendas</h5>
                <small class="text-muted">Resumo semanal/mensal</small>
            </div>
            <div class="card-body">
                <canvas id="salesChart" height="120"></canvas>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <!-- Estatísticas rápidas -->
    <div class="col-md-4 mb-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Total de Vendas</h6>
                <h3 class="fw-bold text-success">{{ $totalSales ?? 0 }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Receita (€)</h6>
                <h3 class="fw-bold text-primary">{{ number_format($totalRevenue ?? 0, 2, ',', '.') }}</h3>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-3">
        <div class="card text-center shadow-sm">
            <div class="card-body">
                <h6 class="text-muted">Produtos Vendidos</h6>
                <h3 class="fw-bold text-dark">{{ $totalProducts ?? 0 }}</h3>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<!-- Chart.js (via CDN) -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('salesChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: @json($labels),  // Ex: ['Seg', 'Ter', 'Qua', ...]
            datasets: [{
                label: 'Vendas',
                data: @json($values), // Ex: [12, 19, 3, 5, 2, 3]
                borderColor: '#0d6efd',
                backgroundColor: 'rgba(13, 110, 253, 0.15)',
                fill: true,
                tension: 0.3,
                borderWidth: 2,
                pointBackgroundColor: '#0d6efd',
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
</script>
@endpush
