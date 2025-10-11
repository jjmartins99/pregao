<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('price_list_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('price_list_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->decimal('price', 12, 4);
            $table->decimal('min_quantity', 10, 3)->default(1);
            $table->string('packaging_type')->default('UN');
            $table->timestamps();
            
            $table->unique(['price_list_id', 'product_id', 'packaging_type']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('price_list_items');
    }
};