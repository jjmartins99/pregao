<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('sale_limits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained()->onDelete('cascade');
            $table->integer('max_lines')->default(100);
            $table->decimal('max_quantity_per_line', 10, 3)->default(1000);
            $table->decimal('max_total_amount', 12, 2)->default(100000);
            $table->decimal('max_total_quantity', 12, 3)->default(10000);
            $table->enum('action', ['warn', 'block'])->default('warn');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('sale_limits');
    }
};