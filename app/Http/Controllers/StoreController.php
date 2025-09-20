<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\ProductListing;
use App\Services\MarketplaceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    protected $marketplaceService;

    public function __construct(MarketplaceService $marketplaceService)
    {
        $this->marketplaceService = $marketplaceService;
    }

    public function index(Request $request)
    {
        $query = Store::with(['categories', 'user'])
            ->active()
            ->verified();

        if ($request->has('category')) {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $stores = $query->paginate(12);

        return view('marketplace.stores.index', compact('stores'));
    }

    public function show($slug)
    {
        $store = Store::with(['categories', 'products', 'reviews'])
            ->where('slug', $slug)
            ->active()
            ->firstOrFail();

        $products = ProductListing::where('store_id', $store->id)
            ->where('is_available', true)
            ->with('product')
            ->paginate(16);

        return view('marketplace.stores.show', compact('store', 'products'));
    }

    public function create()
    {
        $categories = StoreCategory::active()->get();
        return view('marketplace.stores.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'contact_email' => 'required|email',
            'contact_phone' => 'required|string',
            'address' => 'required|string',
            'categories' => 'required|array',
            'categories.*' => 'exists:store_categories,id'
        ]);

        try {
            $store = $this->marketplaceService->createStore($validated, Auth::id());
            
            return redirect()->route('stores.show', $store->slug)
                ->with('success', 'Loja criada com sucesso! Aguarde aprovação.');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao criar loja: ' . $e->getMessage());
        }
    }

    public function dashboard($slug)
    {
        $store = Store::where('slug', $slug)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $stats = [
            'total_orders' => $store->orders()->count(),
            'total_revenue' => $store->orders()->where('status', 'delivered')->sum('total'),
            'pending_orders' => $store->orders()->where('status', 'pending')->count(),
            'active_products' => $store->listings()->where('is_available', true)->count()
        ];

        $recentOrders = $store->orders()
            ->with('customer')
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        return view('marketplace.stores.dashboard', compact('store', 'stats', 'recentOrders'));
    }
}