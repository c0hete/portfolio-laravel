<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\HubEventReporter;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register HubEventReporter as singleton
        $this->app->singleton(HubEventReporter::class, function ($app) {
            return new HubEventReporter();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Report app registration on startup (only in production)
        if (app()->environment('production')) {
            $hub = app(HubEventReporter::class);
            $hub->reportAppRegistered(
                version: config('app.version', '1.0.0'),
                env: config('app.env')
            );
        }
    }
}
