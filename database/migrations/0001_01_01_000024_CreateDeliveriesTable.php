<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('deliveries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('driver_id')->nullable()->constrained('users')->onDelete('set null');
            
            $table->string('tracking_number')->unique();
            $table->string('status')->default('pending');

            // Endereços
            $table->string('pickup_address');
            $table->string('delivery_address');

            // Localizações (geometry em vez de point)
            $table->geometry('pickup_location')->nullable();
            $table->geometry('delivery_location')->nullable();
            $table->geometry('current_location')->nullable();

            // Métricas e tempo
            $table->decimal('distance_km', 8, 2)->nullable();
            $table->decimal('estimated_time_minutes', 8, 2)->nullable();
            $table->timestamp('pickup_time')->nullable();
            $table->timestamp('delivery_time')->nullable();

            // Info do destinatário
            $table->string('recipient_name');
            $table->string('recipient_phone');

            // Notas
            $table->text('delivery_notes')->nullable();
            $table->text('driver_notes')->nullable();

            // Dados de rota (JSON)
            $table->json('route_data')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('deliveries');
    }
};
