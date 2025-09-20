<?php

namespace App\Listeners;

use App\Events\DeliveryAssigned;
use App\Notifications\NewDeliveryAssignmentNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class NotifyDriverNewDelivery implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(DeliveryAssigned $event): void
    {
        $delivery = $event->delivery;
        $driver = $delivery->driver;
        
        try {
            // Notificar o motorista sobre a nova entrega
            Notification::send($driver, new NewDeliveryAssignmentNotification($delivery));
            
            // Também enviar notificação push se configurado
            if (method_exists($driver, 'routeNotificationForFcm')) {
                Notification::send($driver, new NewDeliveryAssignmentNotification($delivery));
            }
            
            Log::info('Driver notified about new delivery assignment', [
                'delivery_id' => $delivery->id,
                'driver_id' => $driver->id,
                'order_id' => $delivery->order_id
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to notify driver about new delivery', [
                'delivery_id' => $delivery->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(DeliveryAssigned $event, $exception): void
    {
        Log::error('NotifyDriverNewDelivery job failed', [
            'delivery_id' => $event->delivery->id,
            'error' => $exception->getMessage()
        ]);
    }
}