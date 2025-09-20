<?php

namespace App\Providers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event to listener mappings for the application.
     *
     * @var array<class-string, array<int, class-string>>
     */
    protected $listen = [
        Registered::class => [
            SendEmailVerificationNotification::class,
        ],

        // Eventos do PREGÃO
        \App\Events\OrderCreated::class => [
            \App\Listeners\SendOrderConfirmation::class,
            \App\Listeners\NotifyStoreOwner::class,
        ],

        \App\Events\OrderStatusUpdated::class => [
            \App\Listeners\NotifyCustomerOrderUpdate::class,
        ],

        \App\Events\DeliveryAssigned::class => [
            \App\Listeners\NotifyDriverNewDelivery::class,
        ],

        \App\Events\DeliveryStatusUpdated::class => [
            \App\Listeners\NotifyCustomerDeliveryUpdate::class,
        ],

        \App\Events\ProductLowStock::class => [
            \App\Listeners\NotifyProductLowStock::class,
        ],

        \App\Events\PaymentProcessed::class => [
            \App\Listeners\UpdateOrderPaymentStatus::class,
        ],

        \App\Events\NewStoreRegistered::class => [
            \App\Listeners\NotifyAdminNewStore::class,
        ],
    ];

    /**
     * Register any events for your application.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Determine if events and listeners should be automatically discovered.
     */
    public function shouldDiscoverEvents(): bool
    {
        return false;
    }
}