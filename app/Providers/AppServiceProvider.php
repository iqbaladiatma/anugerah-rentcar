<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Event;
use App\Events\CustomerCreated;
use App\Events\BookingCreated;
use App\Listeners\SendCustomerNotifications;
use App\Listeners\SendBookingNotifications;

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
        // Register event listeners for notifications
        Event::listen(CustomerCreated::class, SendCustomerNotifications::class);
        Event::listen(BookingCreated::class, SendBookingNotifications::class);
    }
}
