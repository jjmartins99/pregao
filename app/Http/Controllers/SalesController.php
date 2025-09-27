<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{
    /**
     * Mostra o gráfico e resumo das vendas do lojista autenticado
     */
    public function index(Request $request)
    {
        $vendorId = auth()->id(); // ID do lojista autenticado
        $period = $request->get('period', 'weekly'); // "weekly" ou "monthly"

        if ($period === 'monthly') {
            // Agrupar vendas por mês
            $sales = DB::table('orders')
                ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as label, COUNT(*) as total_orders, SUM(total_amount) as revenue, SUM(total_items) as products')
                ->where('vendor_id', $vendorId)
                ->groupBy('label')
                ->orderBy('label')
                ->take(12)
                ->get();
        } else {
            // Agrupar vendas por dia (últimos 7 dias)
            $sales = DB::table('orders')
                ->selectRaw('DATE(created_at) as label, COUNT(*) as total_orders, SUM(total_amount) as revenue, SUM(total_items) as products')
                ->where('vendor_id', $vendorId)
                ->where('created_at', '>=', Carbon::now()->subDays(7))
                ->groupBy('label')
                ->orderBy('label')
                ->get();
        }

        // Preparar dados para o gráfico
        $labels = $sales->pluck('label')->map(function ($date) use ($period) {
            return $period === 'monthly'
                ? Carbon::createFromFormat('Y-m', $date)->translatedFormat('F Y')
                : Carbon::parse($date)->translatedFormat('d M');
        });

        $values = $sales->pluck('total_orders');

        // Totais
        $totalSales = $sales->sum('total_orders');
        $totalRevenue = $sales->sum('revenue');
        $totalProducts = $sales->sum('products');

        return view('vendor.sales', [
            'labels' => $labels,
            'values' => $values,
            'totalSales' => $totalSales,
            'totalRevenue' => $totalRevenue,
            'totalProducts' => $totalProducts,
            'period' => $period,
        ]);
    }
}
