<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use Illuminate\Http\Request;

class DeliveryGeoJsonController extends Controller
{
    public function index()
    {
        $deliveries = Delivery::with('driver.user')->get();

        $features = [];

        foreach ($deliveries as $delivery) {
            $features[] = [
                "type" => "Feature",
                "geometry" => [
                    "type" => "Point",
                    "coordinates" => [
                        $delivery->pickup_location->getLng(),
                        $delivery->pickup_location->getLat(),
                    ]
                ],
                "properties" => [
                    "type" => "pickup",
                    "tracking_number" => $delivery->tracking_number,
                    "pickup_address" => $delivery->pickup_address,
                    "delivery_address" => $delivery->delivery_address,
                    "status" => $delivery->status,
                    "driver" => $delivery->driver?->user?->name ?? "N/A"
                ]
            ];

            $features[] = [
                "type" => "Feature",
                "geometry" => [
                    "type" => "Point",
                    "coordinates" => [
                        $delivery->delivery_location->getLng(),
                        $delivery->delivery_location->getLat(),
                    ]
                ],
                "properties" => [
                    "type" => "dropoff",
                    "tracking_number" => $delivery->tracking_number,
                    "pickup_address" => $delivery->pickup_address,
                    "delivery_address" => $delivery->delivery_address,
                    "status" => $delivery->status,
                    "driver" => $delivery->driver?->user?->name ?? "N/A"
                ]
            ];

            $features[] = [
                "type" => "Feature",
                "geometry" => [
                    "type" => "LineString",
                    "coordinates" => [
                        [
                            $delivery->pickup_location->getLng(),
                            $delivery->pickup_location->getLat()
                        ],
                        [
                            $delivery->delivery_location->getLng(),
                            $delivery->delivery_location->getLat()
                        ]
                    ]
                ],
                "properties" => [
                    "type" => "route",
                    "tracking_number" => $delivery->tracking_number,
                    "status" => $delivery->status,
                    "driver" => $delivery->driver?->user?->name ?? "N/A"
                ]
            ];
        }

        return response()->json([
            "type" => "FeatureCollection",
            "features" => $features
        ]);
    }
}
