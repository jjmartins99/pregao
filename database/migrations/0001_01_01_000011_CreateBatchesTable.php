<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->string('batch_number');
            $table->date('expiry_date')->nullable();
            $table->date('production_date')->nullable();
            $table->decimal('quantity', 12, 3)->default(0);
            $table->decimal('cost_price', 12, 4)->default(0);
            $table->decimal('selling_price', 12, 4)->default(0);
            $table->timestamps();
            
            $table->index(['product_id', 'warehouse_id']);
            $table->index('expiry_date');
        });
    }

    public function down()
    {
        Schema::dropIfExists('batches');
    }
};