<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\CacheService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PerformanceServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Register CacheService as singleton
        $this->app->singleton(CacheService::class, function ($app) {
            return new CacheService();
        });

        // Merge performance config
        $this->mergeConfigFrom(
            config_path('performance.php'),
            'performance'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // Enable query logging for slow query detection in debug mode
        if (config('performance.log_queries') || config('app.debug')) {
            $this->enableQueryLogging();
        }

        // Publish config file
        $this->publishes([
            __DIR__.'/../../config/performance.php' => config_path('performance.php'),
        ], 'performance-config');
    }

    /**
     * Enable query logging for performance monitoring.
     */
    protected function enableQueryLogging(): void
    {
        DB::listen(function ($query) {
            $slowThreshold = config('performance.slow_query_threshold', 100);
            
            if ($query->time > $slowThreshold) {
                Log::channel('performance')->warning('Slow query detected', [
                    'sql' => $query->sql,
                    'bindings' => $query->bindings,
                    'time_ms' => $query->time,
                    'connection' => $query->connectionName,
                ]);
            }
        });
    }
}
