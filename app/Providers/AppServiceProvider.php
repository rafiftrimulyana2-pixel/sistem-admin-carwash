<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

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
        // Membagikan data stok kritis ke semua view (termasuk app.blade.php)
        view()->composer('*', function ($view) {
            if (auth()->check()) {

        // Jika model Stok belum ada, gunakan ini agar sistem tetap aman
        $stokKritis = class_exists('\App\Models\Stok')
            ? \App\Models\Stok::where('stok', '<=', 5)->get()
            : collect([]);
        $view->with('stokKritis', $stokKritis);
            }
        });
    }
}
