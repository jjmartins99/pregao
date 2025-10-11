<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Store;
use App\Models\Category;
use Illuminate\Http\Request;

class MarketplaceController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::with(['store', 'reviews'])
            ->where('is_active', true)
            ->where('quantity', '>', 0)
            ->orderBy('created_at', 'desc')
            ->take(8)
            ->get();

        $featuredStores = Store::withCount(['products', 'sales', 'followers'])
            ->where('is_active', true)
            ->where('is_verified', true)
            ->orderBy('rating', 'desc')
            ->take(6)
            ->get();

        $featuredCategories = Category::withCount('products')
            ->where('is_active', true)
            ->orderBy('products_count', 'desc')
            ->take(8)
            ->get();

        $stats = [
            'total_products' => Product::where('is_active', true)->count(),
            'total_stores' => Store::where('is_active', true)->count(),
            'total_orders' => \App\Models\Order::count(),
            'satisfied_customers' => \App\Models\User::whereHas('orders')->count(),
        ];

        return view('marketplace.index', compact(
            'featuredProducts',
            'featuredStores',
            'featuredCategories',
            'stats'
        ));
    }

    public function category($slug)
    {
        $category = Category::where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = Product::with(['store', 'reviews'])
            ->where('category_id', $category->id)
            ->where('is_active', true)
            ->paginate(12);

        return view('marketplace.category', compact('category', 'products'));
    }

    public function search(Request $request)
    {
        $query = $request->get('q');
        $category = $request->get('category');
        $minPrice = $request->get('min_price');
        $maxPrice = $request->get('max_price');
        $sort = $request->get('sort', 'newest');

        $products = Product::with(['store', 'reviews'])
            ->where('is_active', true)
            ->when($query, function ($q) use ($query) {
                return $q->where('name', 'like', "%{$query}%")
                       ->orWhere('description', 'like', "%{$query}%");
            })
            ->when($category, function ($q) use ($category) {
                return $q->where('category_id', $category);
            })
            ->when($minPrice, function ($q) use ($minPrice) {
                return $q->where('price', '>=', $minPrice);
            })
            ->when($maxPrice, function ($q) use ($maxPrice) {
                return $q->where('price', '<=', $maxPrice);
            })
            ->when($sort, function ($q) use ($sort) {
                return match ($sort) {
                    'price_asc' => $q->orderBy('price', 'asc'),
                    'price_desc' => $q->orderBy('price', 'desc'),
                    'rating' => $q->orderBy('rating', 'desc'),
                    'newest' => $q->orderBy('created_at', 'desc'),
                    default => $q->orderBy('created_at', 'desc')
                };
            })
            ->paginate(12);

        $categories = Category::where('is_active', true)->get();

        return view('marketplace.search', compact('products', 'categories', 'query'));
    }

    public function showProduct($slug)
    {
        $product = Product::with(['store', 'reviews.user', 'category'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        // Increment view count
        $product->increment('views');

        $relatedProducts = Product::with(['store', 'reviews'])
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('is_active', true)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('marketplace.products.show', compact('product', 'relatedProducts'));
    }

    public function stores()
    {
        $stores = Store::withCount(['products', 'sales', 'followers'])
            ->where('is_active', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        return view('marketplace.stores.index', compact('stores'));
    }

    public function showStore($slug)
    {
        $store = Store::withCount(['products', 'sales', 'followers'])
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        $products = Product::with(['reviews'])
            ->where('store_id', $store->id)
            ->where('is_active', true)
            ->paginate(12);

        return view('marketplace.stores.show', compact('store', 'products'));
    }
}