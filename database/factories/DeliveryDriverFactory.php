<?php

namespace Database\Factories;

use App\Models\DeliveryDriver;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use MatanYadaev\EloquentSpatial\Objects\Point;

class DeliveryDriverFactory extends Factory
{
    protected $model = DeliveryDriver::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'vehicle_type' => $this->faker->randomElement(['car', 'bike', 'motorbike', 'van']),
            'license_plate' => strtoupper($this->faker->bothify('??-##-??')),
            'available' => $this->faker->boolean(),

            'current_location' => new Point(
                $this->faker->latitude(-8.9, -8.7),
                $this->faker->longitude(13.0, 13.3)
            ),
        ];
    }
}
