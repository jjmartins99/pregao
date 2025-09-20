<?php

namespace App\Services;

use App\Models\Store;
use App\Models\ProductListing;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Exception;

class MarketplaceService
{
    protected $stockService;
    protected $paymentService;

    public function __construct(StockService $stockService, PaymentService $paymentService)
    {
        $this->stockService = $stockService;
        $this->paymentService = $paymentService;
    }

    /**
     * Criar uma nova loja
     */
    public function createStore($data, $userId)
    {
        return DB::transaction(function () use ($data, $userId) {
            $store = Store::create([
                'user_id' => $userId,
                'name' => $data['name'],
                'slug' => $this->generateUniqueSlug($data['name']),
                'description' => $data['description'] ?? null,
                'contact_email' => $data['contact_email'],
                'contact_phone' => $data['contact_phone'],
                'address' => $data['address'] ?? null,
                'is_active' => false // Requer aprovação
            ]);

            if (isset($data['categories'])) {
                $store->categories()->sync($data['categories']);
            }

            return $store;
        });
    }

    /**
     * Listar produto na loja
     */
    public function listProduct($storeId, $productId, $data)
    {
        return DB::transaction(function () use ($storeId, $productId, $data) {
            $listing = ProductListing::updateOrCreate(
                [
                    'store_id' => $storeId,
                    'product_id' => $productId
                ],
                [
                    'price' => $data['price'],
                    'sale_price' => $data['sale_price'] ?? null,
                    'quantity' => $data['quantity'] ?? 0,
                    'min_order_quantity' => $data['min_order_quantity'] ?? 1,
                    'max_order_quantity' => $data['max_order_quantity'] ?? 100,
                    'description' => $data['description'] ?? null,
                    'images' => $data['images'] ?? null,
                    'specifications' => $data['specifications'] ?? null,
                    'is_available' => ($data['quantity'] ?? 0) > 0
                ]
            );

            return $listing;
        });
    }

    /**
     * Processar pedido do marketplace
     */
    public function processMarketplaceOrder($customerId, $items, $shippingData, $paymentData)
    {
        return DB::transaction(function () use ($customerId, $items, $shippingData, $paymentData) {
            // Agrupar itens por loja
            $storesItems = [];
            foreach ($items as $item) {
                $listing = ProductListing::with('store')->findOrFail($item['listing_id']);
                $storesItems[$listing->store_id][] = [
                    'listing' => $listing,
                    'quantity' => $item['quantity']
                ];
            }

            $orders = [];

            // Criar pedido para cada loja
            foreach ($storesItems as $storeId => $storeItems) {
                $order = $this->createStoreOrder($storeId, $customerId, $storeItems, $shippingData);
                
                // Processar pagamento
                $payment = $this->paymentService->processPayment($order, $paymentData);
                
                if ($payment['success']) {
                    $order->update(['payment_status' => 'paid']);
                    $this->processOrderStock($order);
                    $orders[] = $order;
                } else {
                    throw new Exception("Payment failed: " . $payment['message']);
                }
            }

            return $orders;
        });
    }

    /**
     * Criar pedido para uma loja específica
     */
    protected function createStoreOrder($storeId, $customerId, $items, $shippingData)
    {
        $store = Store::findOrFail($storeId);
        
        $order = Order::create([
            'order_number' => $this->generateOrderNumber(),
            'customer_id' => $customerId,
            'store_id' => $storeId,
            'status' => 'pending',
            'shipping_address' => json_encode($shippingData['address']),
            'shipping_cost' => $this->calculateShippingCost($store, $items, $shippingData)
        ]);

        $subtotal = 0;

        foreach ($items as $itemData) {
            $listing = $itemData['listing'];
            $quantity = $itemData['quantity'];

            // Validar quantidade
            if ($quantity < $listing->min_order_quantity || $quantity > $listing->max_order_quantity) {
                throw new Exception("Invalid quantity for product: " . $listing->product->name);
            }

            if ($listing->quantity < $quantity) {
                throw new Exception("Insufficient stock for product: " . $listing->product->name);
            }

            $itemTotal = $listing->current_price * $quantity;

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $listing->product_id,
                'store_id' => $storeId,
                'product_name' => $listing->product->name,
                'price' => $listing->current_price,
                'quantity' => $quantity,
                'total' => $itemTotal
            ]);

            $subtotal += $itemTotal;
            $listing->incrementSales($quantity);
        }

        // Calcular totais
        $taxAmount = $subtotal * 0.14; // IVA 14%
        $total = $subtotal + $order->shipping_cost + $taxAmount;

        $order->update([
            'subtotal' => $subtotal,
            'tax_amount' => $taxAmount,
            'total' => $total
        ]);

        return $order;
    }

    /**
     * Calcular custo de envio
     */
    protected function calculateShippingCost($store, $items, $shippingData)
    {
        // Implementar lógica de cálculo de frete
        // baseada na distância, peso, etc.
        return 5.00; // Valor fixo por enquanto
    }

    /**
     * Processar stock do pedido
     */
    protected function processOrderStock($order)
    {
        foreach ($order->items as $item) {
            if ($item->product->track_stock) {
                $this->stockService->registerOutgoingStock(
                    $item->product,
                    $order->store->main_warehouse,
                    $item->quantity,
                    [
                        'movement_type' => 'SALE',
                        'reference_id' => $order->id,
                        'reference_type' => Order::class
                    ]
                );
            }
        }
    }

    /**
     * Gerar número de pedido único
     */
    protected function generateOrderNumber()
    {
        return 'ORD-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
    }

    /**
     * Gerar slug único
     */
    protected function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $count = Store::where('slug', 'like', "{$slug}%")->count();
        return $count ? "{$slug}-{$count}" : $slug;
    }
}