<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\DeliveryDriver;

class DeliveryDriverSeeder extends Seeder
{
    public function run(): void
    {
        DeliveryDriver::factory()->count(10)->create();
    }
}
