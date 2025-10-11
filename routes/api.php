<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DeliveryGeoJsonController;

Route::get('/deliveries/geojson', [DeliveryGeoJsonController::class, 'index']);
