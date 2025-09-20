<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\Product;
use App\Models\ProductListing;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductListingController extends Controller
{
    public function index($storeSlug)
    {
        $store = Store::where('slug', $storeSlug)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $listings = ProductListing::where('store_id', $store->id)
            ->with('product')
            ->paginate(20);

        return view('marketplace.listings.index', compact('store', 'listings'));
    }

    public function create($storeSlug)
    {
        $store = Store::where('slug', $storeSlug)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $products = Product::where('company_id', Auth::user()->company_id)
            ->whereNotIn('id', function($query) use ($store) {
                $query->select('product_id')
                    ->from('product_listings')
                    ->where('store_id', $store->id);
            })
            ->get();

        return view('marketplace.listings.create', compact('store', 'products'));
    }

    public function store(Request $request, $storeSlug)
    {
        $store = Store::where('slug', $storeSlug)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'price' => 'required|numeric|min:0',
            'sale_price' => 'nullable|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'min_order_quantity' => 'required|integer|min:1',
            'max_order_quantity' => 'required|integer|min:1',
            'description' => 'nullable|string',
            'images' => 'nullable|array',
            'specifications' => 'nullable|array'
        ]);

        try {
            $listing = $this->marketplaceService->listProduct(
                $store->id,
                $validated['product_id'],
                $validated
            );

            return redirect()->route('stores.listings.index', $store->slug)
                ->with('success', 'Produto listado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao listar produto: ' . $e->getMessage());
        }
    }

    public function updateAvailability($id, Request $request)
    {
        $listing = ProductListing::whereHas('store', function($query) {
            $query->where('user_id', Auth::id());
        })->findOrFail($id);

        $listing->update([
            'is_available' => $request->available
        ]);

        return response()->json(['success' => true]);
    }
}