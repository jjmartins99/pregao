<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Vendor\SalesController;

/*
|--------------------------------------------------------------------------
| Vendor Routes
|--------------------------------------------------------------------------
| Rotas específicas para o painel do lojista (vendors)
| Estas rotas normalmente ficam protegidas por middleware de autenticação
| e de role/vendor.
|
*/

Route::middleware(['auth', 'role:vendor'])->prefix('vendor')->name('vendor.')->group(function () {
    
    // Dashboard principal do vendor
    Route::get('/dashboard', function () {
        return view('vendor.dashboard');
    })->name('dashboard');

    // Página de vendas (gráficos, resumo, etc.)
    Route::get('/sales', [SalesController::class, 'index'])->name('sales');

    // Poderias depois acrescentar:
    // Route::resource('products', VendorProductController::class);
    // Route::resource('orders', VendorOrderController::class);
    // Route::get('store/settings', [VendorStoreController::class, 'edit'])->name('store.settings');
});
