<?php

namespace App\Listeners;

use App\Events\OrderStatusUpdated;
use App\Notifications\OrderStatusUpdatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class NotifyCustomerOrderUpdate implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(OrderStatusUpdated $event): void
    {
        $order = $event->order;
        
        try {
            // Notificar o cliente sobre a atualização do status
            Notification::send(
                $order->customer, 
                new OrderStatusUpdatedNotification($order, $event->oldStatus, $event->newStatus)
            );
            
            Log::info('Customer notified about order status update', [
                'order_id' => $order->id,
                'old_status' => $event->oldStatus,
                'new_status' => $event->newStatus
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to notify customer about order status update', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(OrderStatusUpdated $event, $exception): void
    {
        Log::error('NotifyCustomerOrderUpdate job failed', [
            'order_id' => $event->order->id,
            'error' => $exception->getMessage()
        ]);
    }
}