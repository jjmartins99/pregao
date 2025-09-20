<?php

namespace App\Http\Controllers;

use App\Models\Delivery;
use App\Models\DeliveryDriver;
use App\Services\DeliveryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeliveryController extends Controller
{
    protected $deliveryService;

    public function __construct(DeliveryService $deliveryService)
    {
        $this->deliveryService = $deliveryService;
    }

    public function index(Request $request)
    {
        $query = Delivery::with(['order', 'driver', 'order.store']);

        if (Auth::user()->hasRole('driver')) {
            $query->where('driver_id', Auth::id());
        } elseif (Auth::user()->hasRole('seller')) {
            $query->whereHas('order', function($q) {
                $q->whereHas('store', function($q2) {
                    $q2->where('user_id', Auth::id());
                });
            });
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $deliveries = $query->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('delivery.index', compact('deliveries'));
    }

    public function show($trackingNumber)
    {
        $delivery = Delivery::with([
                'order.items.product', 
                'order.customer', 
                'order.store',
                'driver'
            ])
            ->where('tracking_number', $trackingNumber)
            ->firstOrFail();

        $this->authorize('view', $delivery);

        return view('delivery.show', compact('delivery'));
    }

    public function updateStatus($id, Request $request)
    {
        $delivery = Delivery::findOrFail($id);
        
        $this->authorize('update', $delivery);

        $validated = $request->validate([
            'status' => 'required|in:assigned,picked_up,in_transit,out_for_delivery,delivered,failed,cancelled',
            'notes' => 'nullable|string'
        ]);

        try {
            $this->deliveryService->updateDeliveryStatus(
                $delivery->id,
                $validated['status'],
                $validated['notes'] ?? null
            );

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function updateLocation(Request $request)
    {
        $validated = $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric'
        ]);

        try {
            $driver = $this->deliveryService->updateDriverLocation(
                Auth::id(),
                $validated['latitude'],
                $validated['longitude']
            );

            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }

    public function driverDashboard()
    {
        $driver = DeliveryDriver::where('user_id', Auth::id())->firstOrFail();
        
        $currentDeliveries = Delivery::where('driver_id', Auth::id())
            ->whereIn('status', ['assigned', 'picked_up', 'in_transit', 'out_for_delivery'])
            ->with('order')
            ->get();

        $completedDeliveries = Delivery::where('driver_id', Auth::id())
            ->where('status', 'delivered')
            ->count();

        $totalEarnings = $driver->earnings;

        return view('delivery.driver-dashboard', compact(
            'driver', 'currentDeliveries', 'completedDeliveries', 'totalEarnings'
        ));
    }

    public function availableDeliveries()
    {
        $driver = DeliveryDriver::where('user_id', Auth::id())->firstOrFail();
        
        $availableDeliveries = $this->deliveryService->getNearbyDeliveries(
            $driver->current_location['lat'] ?? 0,
            $driver->current_location['lng'] ?? 0,
            20 // 20km radius
        );

        return view('delivery.available', compact('availableDeliveries'));
    }

    public function acceptDelivery($deliveryId)
    {
        try {
            $this->deliveryService->assignDriver($deliveryId, Auth::id());
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 422);
        }
    }
}