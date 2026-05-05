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

        $stokKritis = collect([
            (object)['nama_bahan' => 'Sabun Wax (Contoh)', 'stok' => 2],
            (object)['nama_bahan' => 'Semir Ban (Contoh)', 'stok' => 4]
        ]);
        $view->with('stokKritis', $stokKritis);
            }
        });
    }
}
