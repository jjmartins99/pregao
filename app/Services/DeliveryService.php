<?php

namespace App\Services;

use App\Models\Delivery;
use App\Models\DeliveryDriver;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Exception;

class DeliveryService
{
    protected $routingService;

    public function __construct(RoutingService $routingService)
    {
        $this->routingService = $routingService;
    }

    /**
     * Criar entrega para um pedido
     */
    public function createDelivery(Order $order, $deliveryData)
    {
        return DB::transaction(function () use ($order, $deliveryData) {
            // Calcular rota e estimativas
            $routeInfo = $this->routingService->calculateRoute(
                $order->store->address,
                $deliveryData['delivery_address']
            );

            $delivery = Delivery::create([
                'order_id' => $order->id,
                'tracking_number' => $this->generateTrackingNumber(),
                'pickup_address' => $order->store->address,
                'delivery_address' => $deliveryData['delivery_address'],
                'distance_km' => $routeInfo['distance'],
                'estimated_time_minutes' => $routeInfo['duration'],
                'recipient_name' => $deliveryData['recipient_name'],
                'recipient_phone' => $deliveryData['recipient_phone'],
                'delivery_notes' => $deliveryData['notes'] ?? null,
                'route_data' => $routeInfo
            ]);

            // Tentar atribuir automaticamente a um motorista
            $this->assignDriver($delivery);

            return $delivery;
        });
    }

    /**
     * Atribuir motorista à entrega
     */
    public function assignDriver(Delivery $delivery, $driverId = null)
    {
        return DB::transaction(function () use ($delivery, $driverId) {
            if ($driverId) {
                $driver = DeliveryDriver::findOrFail($driverId);
            } else {
                $driver = $this->findAvailableDriver($delivery);
            }

            if ($driver && $driver->is_available && $driver->is_online) {
                $delivery->update([
                    'driver_id' => $driver->id,
                    'status' => 'assigned'
                ]);

                $driver->increment('active_deliveries');
                
                // Notificar motorista
                $this->notifyDriver($driver, $delivery);

                return true;
            }

            return false;
        });
    }

    /**
     * Encontrar motorista disponível
     */
    protected function findAvailableDriver(Delivery $delivery)
    {
        return DeliveryDriver::where('is_online', true)
            ->where('is_available', true)
            ->where('active_deliveries', '<', 3) // Máximo 3 entregas ativas
            ->whereRaw('ST_Contains(coverage_areas, ST_GeomFromText(?, 4326))', [
                "POINT({$delivery->delivery_address['lng']} {$delivery->delivery_address['lat']})"
            ])
            ->orderBy('active_deliveries', 'asc')
            ->orderBy('rating', 'desc')
            ->first();
    }

    /**
     * Atualizar localização do motorista
     */
    public function updateDriverLocation($driverId, $latitude, $longitude)
    {
        $driver = DeliveryDriver::findOrFail($driverId);
        
        $driver->update([
            'current_location' => ['lat' => $latitude, 'lng' => $longitude]
        ]);

        // Atualizar localização nas entregas ativas
        $driver->deliveries()
            ->whereIn('status', ['assigned', 'picked_up', 'in_transit', 'out_for_delivery'])
            ->update([
                'current_location' => ['lat' => $latitude, 'lng' => $longitude]
            ]);

        return $driver;
    }

    /**
     * Atualizar status da entrega
     */
    public function updateDeliveryStatus($deliveryId, $status, $notes = null)
    {
        return DB::transaction(function () use ($deliveryId, $status, $notes) {
            $delivery = Delivery::findOrFail($deliveryId);
            
            $updateData = ['status' => $status];
            
            if ($notes) {
                $updateData['driver_notes'] = $notes;
            }

            // Registrar timestamps específicos
            if ($status === 'picked_up') {
                $updateData['pickup_time'] = now();
            } elseif ($status === 'delivered') {
                $updateData['delivery_time'] = now();
                
                // Atualizar estatísticas do motorista
                $delivery->driver->increment('total_deliveries');
                $delivery->driver->decrement('active_deliveries');
                
                // Calcular ganhos
                $earnings = $this->calculateEarnings($delivery);
                $delivery->driver->increment('earnings', $earnings);
            }

            $delivery->update($updateData);

            // Atualizar status do pedido se necessário
            if ($status === 'delivered') {
                $delivery->order->update(['status' => 'delivered']);
            } elseif ($status === 'cancelled') {
                $delivery->order->update(['status' => 'cancelled']);
            }

            return $delivery;
        });
    }

    /**
     * Calcular ganhos da entrega
     */
    protected function calculateEarnings(Delivery $delivery)
    {
        // Base + (distância * taxa por km) + bônus por urgência
        $baseRate = 2.00;
        $distanceRate = 0.50;
        $urgencyBonus = 0;
        
        // Bônus para entregas urgentes (menos de 1 hora)
        if ($delivery->estimated_time_minutes < 60) {
            $urgencyBonus = 1.00;
        }

        return $baseRate + ($delivery->distance_km * $distanceRate) + $urgencyBonus;
    }

    /**
     * Gerar número de rastreamento único
     */
    protected function generateTrackingNumber()
    {
        return 'TRK-' . now()->format('Ymd') . '-' . strtoupper(Str::random(8));
    }

    /**
     * Notificar motorista
     */
    protected function notifyDriver($driver, $delivery)
    {
        // Implementar notificação (email, push notification, SMS)
        // Usar Laravel Notifications ou serviços externos
    }

    /**
     * Obter entregas próximas
     */
    public function getNearbyDeliveries($latitude, $longitude, $radiusKm = 10)
    {
        return Delivery::where('status', 'assigned')
            ->whereRaw('ST_Distance_Sphere(current_location, ST_GeomFromText(?, 4326)) <= ?', [
                "POINT({$longitude} {$latitude})",
                $radiusKm * 1000
            ])
            ->with(['order', 'driver'])
            ->get();
    }
}