<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Warehouse;
use App\Models\StockMovement;
use App\Services\StockService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StockController extends Controller
{
    protected $stockService;

    public function __construct(StockService $stockService)
    {
        $this->stockService = $stockService;
        $this->middleware('auth');
        $this->middleware('permission:manage_stock');
    }

    public function index(Request $request)
    {
        $companyId = Auth::user()->company_id;
        $warehouses = Warehouse::whereHas('branch', function($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })->get();

        $products = Product::where('company_id', $companyId)
            ->where('track_stock', true)
            ->with(['unit', 'batches' => function($query) {
                $query->with('warehouse');
            }])
            ->paginate(25);

        return view('stock.index', compact('products', 'warehouses'));
    }

    public function addStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity' => 'required|numeric|min:0.01',
            'cost_price' => 'required|numeric|min:0',
            'batch_number' => 'nullable|string',
            'expiry_date' => 'nullable|date',
            'movement_type' => 'required|in:PURCHASE,ADJUSTMENT,PRODUCTION_IN,TRANSFER_IN'
        ]);

        $product = Product::findOrFail($request->product_id);
        $warehouse = Warehouse::findOrFail($request->warehouse_id);

        try {
            $result = $this->stockService->registerIncomingStock(
                $product,
                $warehouse,
                $request->quantity,
                $request->cost_price,
                $request->only(['batch_number', 'expiry_date', 'movement_type', 'notes'])
            );

            return response()->json([
                'success' => true,
                'message' => 'Stock added successfully',
                'batch' => $result['batch'],
                'movement' => $result['movement']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function adjustStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'new_quantity' => 'required|numeric|min:0',
            'reason' => 'required|string'
        ]);

        $product = Product::findOrFail($request->product_id);
        $warehouse = Warehouse::findOrFail($request->warehouse_id);

        try {
            $result = $this->stockService->adjustStock(
                $product,
                $warehouse,
                $request->new_quantity,
                $request->reason
            );

            return response()->json([
                'success' => true,
                'message' => 'Stock adjusted successfully',
                'adjustment' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function transferStock(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'from_warehouse_id' => 'required|exists:warehouses,id',
            'to_warehouse_id' => 'required|exists:warehouses,id|different:from_warehouse_id',
            'quantity' => 'required|numeric|min:0.01'
        ]);

        $product = Product::findOrFail($request->product_id);
        $fromWarehouse = Warehouse::findOrFail($request->from_warehouse_id);
        $toWarehouse = Warehouse::findOrFail($request->to_warehouse_id);

        try {
            $result = $this->stockService->transferStock(
                $product,
                $fromWarehouse,
                $toWarehouse,
                $request->quantity
            );

            return response()->json([
                'success' => true,
                'message' => 'Stock transferred successfully',
                'transfer' => $result
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function movementHistory(Request $request)
    {
        $companyId = Auth::user()->company_id;
        
        $movements = StockMovement::whereHas('product', function($query) use ($companyId) {
            $query->where('company_id', $companyId);
        })
        ->with(['product', 'warehouse', 'batch', 'user'])
        ->orderBy('created_at', 'desc')
        ->paginate(50);

        return view('stock.history', compact('movements'));
    }
}