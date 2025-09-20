<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_listings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('store_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 12, 4);
            $table->decimal('sale_price', 12, 4)->nullable();
            $table->integer('quantity')->default(0);
            $table->integer('min_order_quantity')->default(1);
            $table->integer('max_order_quantity')->default(100);
            $table->boolean('is_available')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->integer('views')->default(0);
            $table->integer('sales')->default(0);
            $table->text('description')->nullable();
            $table->json('images')->nullable();
            $table->json('specifications')->nullable();
            $table->timestamps();
            $table->softDeletes();
            
            $table->unique(['store_id', 'product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_listings');
    }
};