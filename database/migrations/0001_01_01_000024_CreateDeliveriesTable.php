<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('set null');
            $table->string('tracking_number')->unique();
            $table->enum('status', [
                'pending', 'assigned', 'picked_up', 'in_transit', 
                'out_for_delivery', 'delivered', 'failed', 'cancelled'
            ])->default('pending');
            $table->text('pickup_address');
            $table->text('delivery_address');
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->decimal('estimated_time_minutes', 8, 2)->nullable();
            $table->timestamp('pickup_time')->nullable();
            $table->timestamp('delivery_time')->nullable();
            $table->string('recipient_name');
            $table->string('recipient_phone');
            $table->text('delivery_notes')->nullable();
            $table->text('driver_notes')->nullable();
            $table->point('current_location')->nullable();
            $table->json('route_data')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('deliveries');
    }
};