<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('delivery_drivers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('vehicle_type')->nullable();
            $table->string('license_plate')->nullable();
            $table->boolean('available')->default(true);
            $table->geometry('current_location')->nullable(); // substituto do point()
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('delivery_drivers');
    }
};
