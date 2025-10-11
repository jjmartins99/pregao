<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('stock_movements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->foreignId('warehouse_id')->constrained()->onDelete('cascade');
            $table->foreignId('batch_id')->nullable()->constrained()->onDelete('set null');
            $table->decimal('quantity', 12, 3);
            $table->enum('type', ['IN', 'OUT']);
            $table->enum('movement_type', [
                'PURCHASE', 'SALE', 'ADJUSTMENT', 'TRANSFER_IN', 'TRANSFER_OUT',
                'PRODUCTION_IN', 'PRODUCTION_OUT', 'SAMPLE', 'DONATION', 'LOSS'
            ]);
            $table->foreignId('reference_id')->nullable(); // ID from related table (sale, purchase, etc.)
            $table->string('reference_type')->nullable(); // Model class of reference
            $table->text('notes')->nullable();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->timestamps();
            
            $table->index(['product_id', 'warehouse_id']);
            $table->index(['reference_id', 'reference_type']);
            $table->index('movement_type');
        });
    }

    public function down()
    {
        Schema::dropIfExists('stock_movements');
    }
};