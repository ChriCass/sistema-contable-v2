<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CompraVenta;
use App\Livewire\DashboardEmpresa;
use App\Livewire\SeleccEmpresa;


Route::redirect('/', '/login');

// Agrupar rutas que requieren autenticación
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', SeleccEmpresa::class)->name('dashboard');
   

    Route::prefix('dashboard/empresa/{id}')->group(function(){
        Route::get('/', DashboardEmpresa::class)->name('empresa.dashboard');
        Route::get('/compra-venta', CompraVenta::class)->name('empresa.compra-venta');
    });

});