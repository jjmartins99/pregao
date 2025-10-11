<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;
use  App\Models\Delivery;

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
