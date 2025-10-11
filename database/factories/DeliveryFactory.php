<?php

namespace Database\Factories;

use App\Models\Delivery;
use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use MatanYadaev\EloquentSpatial\Objects\Point;

class DeliveryFactory extends Factory
{
    protected $model = Delivery::class;

    public function definition(): array
    {
        return [
            'order_id' => Order::factory(),
            'driver_id' => User::factory(),
            'tracking_number' => strtoupper($this->faker->bothify('TRK-#####')),
            'status' => $this->faker->randomElement([
                'pending', 'assigned', 'picked_up', 'in_transit',
                'out_for_delivery', 'delivered', 'failed', 'cancelled'
            ]),

            'pickup_address' => $this->faker->address(),
            'delivery_address' => $this->faker->address(),

            // Localizações como Points
            'pickup_location' => new Point(
                $this->faker->latitude(-8.9, -8.7), // exemplo Luanda
                $this->faker->longitude(13.0, 13.3)
            ),
            'delivery_location' => new Point(
                $this->faker->latitude(-8.9, -8.7),
                $this->faker->longitude(13.0, 13.3)
            ),
            'current_location' => new Point(
                $this->faker->latitude(-8.9, -8.7),
                $this->faker->longitude(13.0, 13.3)
            ),

            'distance_km' => $this->faker->randomFloat(2, 1, 50),
            'estimated_time_minutes' => $this->faker->randomFloat(2, 10, 120),
            'pickup_time' => $this->faker->dateTimeBetween('-1 day', 'now'),
            'delivery_time' => $this->faker->dateTimeBetween('now', '+1 day'),

            'recipient_name' => $this->faker->name(),
            'recipient_phone' => $this->faker->phoneNumber(),

            'delivery_notes' => $this->faker->sentence(),
            'driver_notes' => $this->faker->sentence(),

            'route_data' => [
                'steps' => [
                    ['lat' => -8.85, 'lng' => 13.25],
                    ['lat' => -8.82, 'lng' => 13.27],
                ],
            ],
        ];
    }
}
