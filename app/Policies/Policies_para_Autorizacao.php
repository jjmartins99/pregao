<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Order $order)
    {
        return $user->id === $order->customer_id || 
               ($user->hasRole('seller') && $user->id === $order->store->user_id) ||
               $user->hasRole('admin');
    }

    public function update(User $user, Order $order)
    {
        return $user->hasRole('seller') && $user->id === $order->store->user_id ||
               $user->hasRole('admin');
    }
}

class DeliveryPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Delivery $delivery)
    {
        return $user->id === $delivery->driver_id ||
               $user->id === $delivery->order->customer_id ||
               ($user->hasRole('seller') && $user->id === $delivery->order->store->user_id) ||
               $user->hasRole('admin');
    }

    public function update(User $user, Delivery $delivery)
    {
        return $user->id === $delivery->driver_id ||
               $user->hasRole('admin');
    }
}