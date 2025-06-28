<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use App\View\Components\Alert;
use App\Models\CanteenProductCategory;
use Illuminate\Support\Facades\View;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

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
        $this->routes(function () {
            // Route untuk API
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Route untuk Web (HTML)
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }
}
