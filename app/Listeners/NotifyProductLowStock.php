<?php

namespace App\Listeners;

use App\Events\ProductLowStock;
use App\Notifications\ProductLowStockNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class NotifyProductLowStock implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(ProductLowStock $event): void
    {
        $product = $event->product;
        $store = $event->store;
        $storeOwner = $store->user;
        
        try {
            // Notificar o dono da loja sobre stock baixo
            Notification::send(
                $storeOwner, 
                new ProductLowStockNotification($product, $store, $event->currentStock, $event->minStock)
            );
            
            // Também notificar administradores se necessário
            $admins = User::where('role', 'admin')->get();
            if ($admins->count() > 0) {
                Notification::send(
                    $admins, 
                    new ProductLowStockNotification($product, $store, $event->currentStock, $event->minStock)
                );
            }
            
            Log::warning('Low stock notification sent', [
                'product_id' => $product->id,
                'store_id' => $store->id,
                'current_stock' => $event->currentStock,
                'min_stock' => $event->minStock
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send low stock notification', [
                'product_id' => $product->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(ProductLowStock $event, $exception): void
    {
        Log::error('NotifyProductLowStock job failed', [
            'product_id' => $event->product->id,
            'error' => $exception->getMessage()
        ]);
    }
}