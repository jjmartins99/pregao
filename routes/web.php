<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
// routes/web.php
Route::get('/health', function() {
    return response()->json([
        'status' => 'ok',
        'services' => [
            'database' => DB::connection()->getPdo() ? 'connected' : 'failed',
            'redis' => Redis::connection()->ping() ? 'ok' : 'failed'
        ]
    ]);
});

