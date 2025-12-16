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
        // Register error handling services
        $this->app->singleton(\App\Services\ApplicationLoggerService::class);
        $this->app->singleton(\App\Services\ErrorNotificationService::class);
        $this->app->singleton(\App\Services\ErrorRecoveryService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
