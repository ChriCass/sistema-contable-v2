<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CompraVentaService;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(CompraVentaService::class, function ($app) {
            return new CompraVentaService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
