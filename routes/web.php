<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\CompraVenta;
use App\Livewire\DashboardEmpresa;
use App\Livewire\SeleccEmpresa;
use App\Livewire\CompraVentaFormView;
use App\Livewire\RegistrarAsientoView;
use App\Livewire\CorrentistaView;
use App\Livewire\DiarioView;
use App\Livewire\CajaDiarioView;
use App\Livewire\HojaTrabajoView;
use App\Livewire\PlanContableView;
use App\Livewire\ListaAsientos;
use App\Livewire\RegistrosGeneralesView;
use App\Livewire\MayorView;
use App\Livewire\HojaTrabajoAnalisisView;
use App\Livewire\PlanContableGenForm;
use App\Livewire\ImportadorGeneral;

use App\Livewire\ReportePendientesView;
use App\Livewire\ReporteDetalleView;

Route::redirect('/', '/login');

// Agrupar rutas que requieren autenticación
Route::middleware(['auth:sanctum', config('jetstream.auth_session'), 'verified'])->group(function () {
    Route::get('/dashboard', SeleccEmpresa::class)->name('dashboard');
   

    Route::prefix('dashboard/empresa/{id}')->group(function(){
        Route::get('/', DashboardEmpresa::class)->name('empresa.dashboard');
        Route::get('/compra-venta', CompraVenta::class)->name('empresa.compra-venta');
        Route::get('/compra-venta-form', CompraVentaFormView::class)->name('empresa.compra-venta.form');
        Route::get('/registro-asiento', RegistrarAsientoView::class)->name('empresa.registrar-asiento');
        Route::get('/lista-asiento', ListaAsientos::class)->name('empresa.lista-asiento');
        Route::get('/correntista', CorrentistaView::class)->name('empresa.correntista');
        Route::get('/diario', DiarioView::class)->name('empresa.diario');
        Route::get('/mayor', MayorView::class)->name('empresa.mayor');
        Route::get('/caja-diario', CajaDiarioView::class)->name('empresa.caja-diario');
        Route::get('/pendientes', ReportePendientesView::class)->name('empresa.pendientes');
        Route::get('/detalle', ReporteDetalleView::class)->name('empresa.detalle');
        Route::prefix('/hoja-trabajo/{tipoDeCuenta}')->group(function (){
            Route::get('/', HojaTrabajoAnalisisView::class)->name('empresa.hoja-trabajo-analisis');
        }); 
        
        Route::get('/hoja-trabajo', HojaTrabajoView::class)->name('empresa.hoja-trabajo');
        Route::get('/plan-contable', PlanContableView::class)->name('empresa.plan-contable');
        Route::get('/plan-contable-form', PlanContableGenForm::class)->name('empresa.plan-contable-gen');
        Route::get('/registros-generales', RegistrosGeneralesView::class)->name('empresa.registros-generales');

        Route::get('/importador-general', ImportadorGeneral::class)->name('empresa.importador-general');
    });

});