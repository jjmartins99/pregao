<?php

namespace App\Listeners;

use App\Events\PaymentProcessed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class UpdateOrderPaymentStatus implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(PaymentProcessed $event): void
    {
        $order = $event->order;
        
        try {
            // Atualizar o status de pagamento do pedido
            $order->update([
                'payment_status' => $event->paymentStatus,
                'payment_method' => $event->paymentMethod,
                'paid_at' => $event->paymentStatus === 'paid' ? now() : null
            ]);
            
            // Se o pagamento foi confirmado, atualizar o status do pedido
            if ($event->paymentStatus === 'paid') {
                $order->update(['status' => 'confirmed']);
                
                // Disparar evento de atualização de status
                event(new OrderStatusUpdated($order, 'pending', 'confirmed'));
            }
            
            Log::info('Order payment status updated', [
                'order_id' => $order->id,
                'payment_status' => $event->paymentStatus,
                'payment_method' => $event->paymentMethod
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to update order payment status', [
                'order_id' => $order->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(PaymentProcessed $event, $exception): void
    {
        Log::error('UpdateOrderPaymentStatus job failed', [
            'order_id' => $event->order->id,
            'error' => $exception->getMessage()
        ]);
    }
}