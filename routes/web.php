<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

/*
|--------------------------------------------------------------------------
| Web Routes — PREGÃO SPA
|--------------------------------------------------------------------------
|
| Aqui definimos as rotas principais do modo SPA.
| A rota '/' carrega a página Home.vue.
|
*/

// Página inicial do SPA
Route::get('/', fn() => Inertia::render('Home'))->name('home');

// Exemplo: marketplace SPA
Route::get('/marketplace', fn() => Inertia::render('Marketplace/Index'))->name('marketplace');

// Dashboard (acesso autenticado)
Route::get('/dashboard', fn() => Inertia::render('Dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Perfil do utilizador (rotas Breeze)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Rotas Breeze Auth
require __DIR__.'/auth.php';
