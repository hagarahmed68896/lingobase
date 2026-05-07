<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
       // لضمان عمل الروابط بشكل صحيح على Vercel
    $this->app->bind('path.public', function() {
        return base_path('public');
    });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        if (config('app.env') !== 'local') {
            URL::forceScheme('https');
        }
    }
}
