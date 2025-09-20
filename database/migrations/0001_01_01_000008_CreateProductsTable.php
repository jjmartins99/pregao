<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('sku')->unique();
            $table->string('name');
            $table->text('description')->nullable();
            $table->enum('kind', ['GOOD', 'SERVICE']);
            $table->boolean('track_stock')->default(true);
            $table->foreignId('unit_id')->constrained();
            $table->decimal('min_stock', 10, 2)->default(0);
            $table->decimal('max_stock', 10, 2)->nullable();
            $table->boolean('expiry_control')->default(false);
            $table->enum('stock_policy', ['FIFO', 'LIFO', 'FEFO'])->default('FIFO');
            $table->string('barcode')->nullable();
            $table->json('images')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
            
            $table->index(['company_id', 'kind']);
            $table->index(['sku', 'is_active']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};