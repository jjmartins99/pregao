<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\User;
use App\Services\SaleService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class POSController extends Controller
{
    protected $saleService;

    public function __construct(SaleService $saleService)
    {
        $this->saleService = $saleService;
        $this->middleware('auth');
        $this->middleware('permission:pos_access');
    }

    public function index($branchId)
    {
        $branch = Branch::findOrFail($branchId);
        $products = Product::where('company_id', Auth::user()->company_id)
            ->where('is_active', true)
            ->with(['packagings', 'unit'])
            ->get();

        return view('pos.index', compact('branch', 'products'));
    }

    public function processSale(Request $request, $branchId)
    {
        $request->validate([
            'customer_id' => 'required|exists:users,id',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'required|numeric|min:0.01',
            'items.*.packaging_type' => 'required|string',
            'payment_method' => 'required|in:cash,card,transfer,credit'
        ]);

        $branch = Branch::findOrFail($branchId);
        $customer = User::findOrFail($request->customer_id);
        
        try {
            $sale = $this->saleService->createSale(
                $branch,
                $customer,
                Auth::user(),
                $request->items,
                $request->only(['payment_method', 'notes', 'due_date'])
            );

            return response()->json([
                'success' => true,
                'sale' => $sale,
                'message' => 'Sale processed successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 422);
        }
    }

    public function getProductDetails($productId)
    {
        $product = Product::with(['packagings', 'unit', 'batches'])->findOrFail($productId);
        
        return response()->json([
            'product' => $product,
            'stock' => $product->stock_quantity
        ]);
    }

    public function searchProducts(Request $request)
    {
        $search = $request->get('search');
        
        $products = Product::where('company_id', Auth::user()->company_id)
            ->where('is_active', true)
            ->where(function($query) use ($search) {
                $query->where('name', 'like', "%$search%")
                    ->orWhere('sku', 'like', "%$search%")
                    ->orWhere('barcode', 'like', "%$search%");
            })
            ->with(['packagings', 'unit'])
            ->limit(20)
            ->get();

        return response()->json($products);
    }
}