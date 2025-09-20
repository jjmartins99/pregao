<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Notifications\NewOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class NotifyStoreOwner implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        $storeOwner = $order->store->user;
        
        try {
            // Notificar o dono da loja sobre o novo pedido
            Notification::send($storeOwner, new NewOrderNotification($order));
            
            Log::info('Store owner notified about new order', [
                'order_id' => $order->id,
                'store_id' => $order->store_id,
                'store_owner_id' => $storeOwner->id
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to notify store owner', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(OrderCreated $event, $exception): void
    {
        Log::error('NotifyStoreOwner job failed', [
            'order_id' => $event->order->id,
            'error' => $exception->getMessage()
        ]);
    }
}