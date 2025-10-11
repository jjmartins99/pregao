<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Store;
use App\Services\MarketplaceService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    protected $marketplaceService;

    public function __construct(MarketplaceService $marketplaceService)
    {
        $this->marketplaceService = $marketplaceService;
    }

    public function index(Request $request)
    {
        $query = Order::with(['store', 'customer']);

        // Filtros para lojistas
        if (Auth::user()->hasRole('seller')) {
            $query->whereHas('store', function($q) {
                $q->where('user_id', Auth::id());
            });
        }

        // Filtros para clientes
        if (Auth::user()->hasRole('customer')) {
            $query->where('customer_id', Auth::id());
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $orders = $query->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('marketplace.orders.index', compact('orders'));
    }

    public function show($orderNumber)
    {
        $order = Order::with(['items.product', 'store', 'customer', 'delivery'])
            ->where('order_number', $orderNumber)
            ->firstOrFail();

        // Verificar permissões
        $this->authorize('view', $order);

        return view('marketplace.orders.show', compact('order'));
    }

    public function create()
    {
        $cart = session()->get('cart', []);
        
        if (empty($cart)) {
            return redirect()->route('marketplace.index')
                ->with('error', 'Seu carrinho está vazio.');
        }

        $stores = Store::whereIn('id', array_keys($cart))
            ->with('products')
            ->get();

        return view('marketplace.orders.create', compact('stores', 'cart'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'shipping_address' => 'required|array',
            'shipping_address.street' => 'required|string',
            'shipping_address.city' => 'required|string',
            'shipping_address.state' => 'required|string',
            'shipping_address.zip_code' => 'required|string',
            'shipping_address.country' => 'required|string',
            'billing_address' => 'nullable|array',
            'customer_notes' => 'nullable|string',
            'payment_method' => 'required|in:credit_card,debit_card,mpesa,transfer'
        ]);

        $cart = session()->get('cart', []);
        $items = [];

        foreach ($cart as $storeId => $storeItems) {
            foreach ($storeItems as $listingId => $item) {
                $items[] = [
                    'listing_id' => $listingId,
                    'quantity' => $item['quantity']
                ];
            }
        }

        try {
            $orders = $this->marketplaceService->processMarketplaceOrder(
                Auth::id(),
                $items,
                $validated,
                $request->only('payment_method', 'payment_token')
            );

            // Limpar carrinho
            session()->forget('cart');

            return redirect()->route('orders.index')
                ->with('success', 'Pedido realizado com sucesso!');
        } catch (\Exception $e) {
            return back()->with('error', 'Erro ao processar pedido: ' . $e->getMessage());
        }
    }

    public function updateStatus($orderNumber, Request $request)
    {
        $order = Order::where('order_number', $orderNumber)
            ->whereHas('store', function($q) {
                $q->where('user_id', Auth::id());
            })
            ->firstOrFail();

        $validated = $request->validate([
            'status' => 'required|in:confirmed,processing,shipped,cancelled'
        ]);

        $order->update(['status' => $validated['status']]);

        // Se foi enviado, criar entrega
        if ($validated['status'] === 'shipped') {
            $this->deliveryService->createDelivery($order, [
                'delivery_address' => json_decode($order->shipping_address, true),
                'recipient_name' => $order->customer->name,
                'recipient_phone' => $order->customer->phone
            ]);
        }

        return response()->json(['success' => true]);
    }
}