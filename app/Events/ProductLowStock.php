<?php

namespace App\Events;

use App\Models\Product;
use App\Models\Store;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class ProductLowStock
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $product;
    public $store;
    public $currentStock;
    public $minStock;

    /**
     * Create a new event instance.
     */
    public function __construct(Product $product, Store $store, $currentStock, $minStock)
    {
        $this->product = $product;
        $this->store = $store;
        $this->currentStock = $currentStock;
        $this->minStock = $minStock;
    }
}