<?php

namespace App\Listeners;

use App\Events\DeliveryStatusUpdated;
use App\Notifications\DeliveryStatusUpdatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class NotifyCustomerDeliveryUpdate implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(DeliveryStatusUpdated $event): void
    {
        $delivery = $event->delivery;
        $customer = $delivery->order->customer;
        
        try {
            // Notificar o cliente sobre a atualização da entrega
            Notification::send(
                $customer, 
                new DeliveryStatusUpdatedNotification($delivery, $event->oldStatus, $event->newStatus)
            );
            
            Log::info('Customer notified about delivery status update', [
                'delivery_id' => $delivery->id,
                'order_id' => $delivery->order_id,
                'old_status' => $event->oldStatus,
                'new_status' => $event->newStatus
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to notify customer about delivery status update', [
                'delivery_id' => $delivery->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(DeliveryStatusUpdated $event, $exception): void
    {
        Log::error('NotifyCustomerDeliveryUpdate job failed', [
            'delivery_id' => $event->delivery->id,
            'error' => $exception->getMessage()
        ]);
    }
}