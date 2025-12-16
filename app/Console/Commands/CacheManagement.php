<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\CacheService;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Artisan;

class CacheManagement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cache:manage 
                            {action : The action to perform (clear, warm, status, optimize)}
                            {--type= : Specific cache type to manage (settings, fleet, dashboard, reports, all)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Manage application caches for performance optimization';

    /**
     * Execute the console command.
     */
    public function handle(CacheService $cacheService): int
    {
        $action = $this->argument('action');
        $type = $this->option('type') ?? 'all';

        return match ($action) {
            'clear' => $this->clearCache($cacheService, $type),
            'warm' => $this->warmCache($cacheService, $type),
            'status' => $this->showCacheStatus(),
            'optimize' => $this->optimizeCache(),
            default => $this->invalidAction($action),
        };
    }

    /**
     * Clear specified caches.
     */
    protected function clearCache(CacheService $cacheService, string $type): int
    {
        $this->info("Clearing {$type} cache...");

        match ($type) {
            'settings' => $cacheService->clearSettingsCache(),
            'fleet' => $cacheService->clearFleetCache(),
            'dashboard' => $cacheService->clearDashboardCache(),
            'reports' => $cacheService->clearReportCache(),
            'customers' => $cacheService->clearCustomerCache(),
            'all' => $cacheService->clearAllCaches(),
            default => $this->warn("Unknown cache type: {$type}"),
        };

        $this->info("Cache cleared successfully!");
        return Command::SUCCESS;
    }

    /**
     * Warm up caches with fresh data.
     */
    protected function warmCache(CacheService $cacheService, string $type): int
    {
        $this->info("Warming {$type} cache...");

        $tasks = [];

        if ($type === 'all' || $type === 'settings') {
            $tasks[] = ['Settings', fn() => $cacheService->getSettings()];
        }

        if ($type === 'all' || $type === 'fleet') {
            $tasks[] = ['Fleet Statistics', fn() => $cacheService->getFleetStatistics()];
            $tasks[] = ['Maintenance Notifications', fn() => $cacheService->getMaintenanceNotifications()];
        }

        if ($type === 'all' || $type === 'dashboard') {
            $tasks[] = ['Dashboard Stats', fn() => $cacheService->getDashboardStats()];
            $tasks[] = ['Revenue Chart', fn() => $cacheService->getRevenueChartData()];
        }

        if ($type === 'all' || $type === 'customers') {
            $tasks[] = ['Customer Statistics', fn() => $cacheService->getCustomerStatistics()];
        }

        $bar = $this->output->createProgressBar(count($tasks));
        $bar->start();

        foreach ($tasks as [$name, $callback]) {
            try {
                $callback();
                $bar->advance();
            } catch (\Exception $e) {
                $this->newLine();
                $this->error("Failed to warm {$name}: {$e->getMessage()}");
            }
        }

        $bar->finish();
        $this->newLine(2);
        $this->info("Cache warmed successfully!");

        return Command::SUCCESS;
    }

    /**
     * Show cache status and statistics.
     */
    protected function showCacheStatus(): int
    {
        $this->info("Cache Status");
        $this->newLine();

        $driver = config('cache.default');
        $this->line("Cache Driver: <comment>{$driver}</comment>");
        $this->newLine();

        // Show cache store info
        $this->table(
            ['Cache Type', 'TTL (seconds)', 'Status'],
            [
                ['Settings', config('performance.cache.settings', 3600), $this->checkCacheKey('anugerah_rentcar:settings:current')],
                ['Fleet Stats', config('performance.cache.fleet_stats', 300), $this->checkCacheKey('anugerah_rentcar:fleet:statistics')],
                ['Dashboard', config('performance.cache.dashboard', 60), $this->checkCacheKey('anugerah_rentcar:dashboard:stats')],
                ['Customers', config('performance.cache.customers', 300), $this->checkCacheKey('anugerah_rentcar:customers:statistics')],
            ]
        );

        // Show memory usage if Redis
        if ($driver === 'redis') {
            $this->showRedisStats();
        }

        return Command::SUCCESS;
    }

    /**
     * Optimize all caches.
     */
    protected function optimizeCache(): int
    {
        $this->info("Optimizing application caches...");
        $this->newLine();

        // Clear and rebuild Laravel caches
        $commands = [
            'config:cache' => 'Configuration',
            'route:cache' => 'Routes',
            'view:cache' => 'Views',
        ];

        foreach ($commands as $command => $name) {
            $this->line("Caching {$name}...");
            try {
                Artisan::call($command);
                $this->info("  ✓ {$name} cached");
            } catch (\Exception $e) {
                $this->warn("  ✗ {$name} caching failed: {$e->getMessage()}");
            }
        }

        $this->newLine();
        $this->info("Cache optimization complete!");

        return Command::SUCCESS;
    }

    /**
     * Check if a cache key exists.
     */
    protected function checkCacheKey(string $key): string
    {
        return Cache::has($key) ? '<info>Cached</info>' : '<comment>Not cached</comment>';
    }

    /**
     * Show Redis statistics if available.
     */
    protected function showRedisStats(): void
    {
        try {
            $redis = Cache::getStore()->getRedis();
            $info = $redis->info();

            $this->newLine();
            $this->line("Redis Statistics:");
            $this->table(
                ['Metric', 'Value'],
                [
                    ['Used Memory', $info['used_memory_human'] ?? 'N/A'],
                    ['Connected Clients', $info['connected_clients'] ?? 'N/A'],
                    ['Total Keys', $info['db0']['keys'] ?? 'N/A'],
                    ['Hit Rate', isset($info['keyspace_hits'], $info['keyspace_misses']) 
                        ? round($info['keyspace_hits'] / ($info['keyspace_hits'] + $info['keyspace_misses']) * 100, 2) . '%'
                        : 'N/A'],
                ]
            );
        } catch (\Exception $e) {
            $this->warn("Could not retrieve Redis stats: {$e->getMessage()}");
        }
    }

    /**
     * Handle invalid action.
     */
    protected function invalidAction(string $action): int
    {
        $this->error("Invalid action: {$action}");
        $this->line("Available actions: clear, warm, status, optimize");
        return Command::FAILURE;
    }
}
