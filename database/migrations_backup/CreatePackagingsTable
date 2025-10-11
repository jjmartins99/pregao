<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('packagings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('code'); // CX, GRD, FAR, etc.
            $table->decimal('conversion_factor', 10, 3)->default(1);
            $table->string('barcode')->nullable();
            $table->decimal('price_adjustment', 10, 2)->nullable();
            $table->boolean('is_default')->default(false);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['product_id', 'code']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('packagings');
    }
};