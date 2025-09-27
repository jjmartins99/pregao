<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\POSController;
use App\Http\Controllers\StockController;

// ===== REMOVER OU COMENTAR Auth::routes() =====
// Auth::routes(); // COMENTAR ESTA LINHA

// ===== ROTAS API =====
Route::prefix('api')->group(function () {
    Route::get('/marketplace/products', [App\Http\Controllers\Api\MarketplaceController::class, 'products']);
    Route::get('/marketplace/products/{id}', [App\Http\Controllers\Api\MarketplaceController::class, 'show']);
    Route::get('/marketplace/categories', [App\Http\Controllers\Api\MarketplaceController::class, 'categories']);
    Route::get('/marketplace/stores', [App\Http\Controllers\Api\MarketplaceController::class, 'stores']);
    
    // Rotas do carrinho
    Route::get('/cart', [App\Http\Controllers\Api\CartController::class, 'index']);
    Route::post('/cart/add', [App\Http\Controllers\Api\CartController::class, 'add']);
    Route::post('/cart/update/{item}', [App\Http\Controllers\Api\CartController::class, 'update']);
    Route::delete('/cart/remove/{item}', [App\Http\Controllers\Api\CartController::class, 'remove']);
    Route::delete('/cart/clear', [App\Http\Controllers\Api\CartController::class, 'clear']);

    // ===== ROTAS DE AUTH API =====
    //Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
    //Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout']);
    //Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);
    
});

// ===== ROTAS PROTEGIDAS =====
Route::middleware(['auth:sanctum'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    
    // POS Routes
    Route::prefix('pos')->middleware('permission:pos_access')->group(function () {
        Route::get('/{branch}', [POSController::class, 'index'])->name('pos.index');
        Route::post('/{branch}/sale', [POSController::class, 'processSale'])->name('pos.processSale');
        Route::get('/product/{product}', [POSController::class, 'getProductDetails'])->name('pos.productDetails');
        Route::get('/products/search', [POSController::class, 'searchProducts'])->name('pos.searchProducts');
    });
    
    // Stock Management Routes
    Route::prefix('stock')->middleware('permission:manage_stock')->group(function () {
        Route::get('/', [StockController::class, 'index'])->name('stock.index');
        Route::post('/add', [StockController::class, 'addStock'])->name('stock.add');
        Route::post('/adjust', [StockController::class, 'adjustStock'])->name('stock.adjust');
        Route::post('/transfer', [StockController::class, 'transferStock'])->name('stock.transfer');
        Route::get('/history', [StockController::class, 'movementHistory'])->name('stock.history');
    });
});

// Rotas do Marketplace
Route::prefix('marketplace')->group(function () {
    Route::get('/', [MarketplaceController::class, 'index'])->name('marketplace.index');
    Route::get('/categories/{slug}', [MarketplaceController::class, 'category'])->name('marketplace.category');
    
    // Lojas
    Route::get('/stores', [StoreController::class, 'index'])->name('stores.index');
    Route::get('/stores/create', [StoreController::class, 'create'])->name('stores.create');
    Route::post('/stores', [StoreController::class, 'store'])->name('stores.store');
    Route::get('/stores/{slug}', [StoreController::class, 'show'])->name('stores.show');
    Route::get('/stores/{slug}/dashboard', [StoreController::class, 'dashboard'])->name('stores.dashboard');
    
    // Listagens
    Route::get('/stores/{slug}/listings', [ProductListingController::class, 'index'])->name('stores.listings.index');
    Route::get('/stores/{slug}/listings/create', [ProductListingController::class, 'create'])->name('stores.listings.create');
    Route::post('/stores/{slug}/listings', [ProductListingController::class, 'store'])->name('stores.listings.store');
    
    // Carrinho
    Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
    Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
    
    // Pedidos
    Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/create', [OrderController::class, 'create'])->name('orders.create');
    Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
    Route::get('/orders/{orderNumber}', [OrderController::class, 'show'])->name('orders.show');
});

// Rotas de Delivery
Route::prefix('delivery')->group(function () {
    Route::get('/', [DeliveryController::class, 'index'])->name('delivery.index');
    Route::get('/{trackingNumber}', [DeliveryController::class, 'show'])->name('delivery.show');
    
    // Motorista
    Route::get('/driver/dashboard', [DeliveryController::class, 'driverDashboard'])->name('delivery.driver.dashboard');
    Route::get('/driver/available', [DeliveryController::class, 'availableDeliveries'])->name('delivery.driver.available');
    Route::post('/driver/location', [DeliveryController::class, 'updateLocation'])->name('delivery.driver.location');
    Route::post('/driver/accept/{deliveryId}', [DeliveryController::class, 'acceptDelivery'])->name('delivery.driver.accept');
    Route::post('/deliveries/{id}/status', [DeliveryController::class, 'updateStatus'])->name('delivery.update.status');
});

// API Routes para mobile
Route::prefix('api/v1')->group(function () {
    Route::get('/marketplace/products', [Api\MarketplaceApiController::class, 'products']);
    Route::get('/marketplace/stores', [Api\MarketplaceApiController::class, 'stores']);
    Route::get('/marketplace/categories', [Api\MarketplaceApiController::class, 'categories']);
    
    Route::post('/orders', [Api\OrderApiController::class, 'store']);
    Route::get('/orders/{orderNumber}', [Api\OrderApiController::class, 'show']);
    
    Route::get('/delivery/track/{trackingNumber}', [Api\DeliveryApiController::class, 'track']);
    Route::post('/delivery/location', [Api\DeliveryApiController::class, 'updateLocation']);
});




// ===== ROTA SPA (deve ser a última rota) =====
Route::get('/{any}', function () {
    return view('app');
})->where('any', '.*');