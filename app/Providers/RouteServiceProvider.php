<?php

// app/Providers/RouteServiceProvider.php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route; // Pastikan ini diimport

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/dashboard';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot(): void
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });

        $this->routes(function () {
            // Ini adalah bagian penting untuk rute API
            Route::middleware('api') // Memastikan grup middleware 'api' diterapkan
                ->prefix('api')     // Memberikan awalan '/api' pada semua rute di file ini
                ->group(base_path('routes/api.php')); // Memuat file routes/api.php

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    // ... (sisa kode lainnya) ...
}
