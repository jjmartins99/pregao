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
