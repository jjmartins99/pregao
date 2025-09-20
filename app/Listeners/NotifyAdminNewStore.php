<?php

namespace App\Listeners;

use App\Events\NewStoreRegistered;
use App\Models\User;
use App\Notifications\NewStoreRegistrationNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Log;

class NotifyAdminNewStore implements ShouldQueue
{
    use InteractsWithQueue;

    /**
     * Handle the event.
     */
    public function handle(NewStoreRegistered $event): void
    {
        $store = $event->store;
        
        try {
            // Notificar todos os administradores sobre nova loja registrada
            $admins = User::where('role', 'admin')->get();
            
            if ($admins->count() > 0) {
                Notification::send($admins, new NewStoreRegistrationNotification($store));
            }
            
            Log::info('Admins notified about new store registration', [
                'store_id' => $store->id,
                'store_name' => $store->name,
                'admin_count' => $admins->count()
            ]);
            
        } catch (\Exception $e) {
            Log::error('Failed to notify admins about new store', [
                'store_id' => $store->id,
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(NewStoreRegistered $event, $exception): void
    {
        Log::error('NotifyAdminNewStore job failed', [
            'store_id' => $event->store->id,
            'error' => $exception->getMessage()
        ]);
    }
}