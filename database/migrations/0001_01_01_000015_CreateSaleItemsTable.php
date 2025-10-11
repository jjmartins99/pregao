<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sale_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sale_id')->constrained()->onDelete('cascade');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('quantity', 10, 3);
            $table->decimal('unit_price', 12, 4);
            $table->decimal('tax_rate', 5, 2)->default(0);
            $table->decimal('discount_rate', 5, 2)->default(0);
            $table->decimal('discount_amount', 12, 4)->default(0);
            $table->decimal('total', 12, 4);
            $table->string('packaging_type')->default('UN');
            $table->decimal('packaging_factor', 10, 3)->default(1);
            $table->text('notes')->nullable();
            $table->timestamps();
            
            $table->index(['sale_id', 'product_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_items');
    }
};