<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Mail\OrderConfirmationMail;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendOrderConfirmation implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;
        
        try {
            // Enviar email de confirmação para o cliente
            Mail::to($order->customer->email)
                ->send(new OrderConfirmationMail($order));
                
            Log::info('Order confirmation email sent', [
                'order_id' => $order->id,
                'customer_email' => $order->customer->email
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to send order confirmation email', [
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
        Log::error('SendOrderConfirmation job failed', [
            'order_id' => $event->order->id,
            'error' => $exception->getMessage()
        ]);
    }
}