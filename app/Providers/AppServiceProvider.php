<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $lowStockBarangs = \App\Models\Barang_model::where('stok', '<', 10)->get();
            $view->with('lowStockBarangs', $lowStockBarangs);
        });
    }
}
