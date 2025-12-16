<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware for monitoring request performance and logging slow queries.
 */
class PerformanceMonitoringMiddleware
{
    /**
     * Threshold for slow request warning (in milliseconds)
     */
    protected int $slowRequestThreshold;

    /**
     * Threshold for slow query warning (in milliseconds)
     */
    protected int $slowQueryThreshold;

    /**
     * Whether to log query details
     */
    protected bool $logQueries;

    /**
     * Query log for the current request
     */
    protected array $queryLog = [];

    public function __construct()
    {
        $this->slowRequestThreshold = config('performance.slow_request_threshold', 1000);
        $this->slowQueryThreshold = config('performance.slow_query_threshold', 100);
        $this->logQueries = config('performance.log_queries', false);
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $startMemory = memory_get_usage();

        // Enable query logging if configured
        if ($this->logQueries || config('app.debug')) {
            DB::enableQueryLog();
        }

        $response = $next($request);

        $endTime = microtime(true);
        $endMemory = memory_get_usage();

        $executionTime = ($endTime - $startTime) * 1000; // Convert to milliseconds
        $memoryUsed = ($endMemory - $startMemory) / 1024 / 1024; // Convert to MB

        // Get query statistics
        $queries = DB::getQueryLog();
        $queryCount = count($queries);
        $totalQueryTime = array_sum(array_column($queries, 'time'));

        // Log performance metrics
        $this->logPerformanceMetrics($request, [
            'execution_time_ms' => round($executionTime, 2),
            'memory_used_mb' => round($memoryUsed, 2),
            'query_count' => $queryCount,
            'total_query_time_ms' => round($totalQueryTime, 2),
        ]);

        // Log slow requests
        if ($executionTime > $this->slowRequestThreshold) {
            $this->logSlowRequest($request, $executionTime, $queries);
        }

        // Log slow queries
        $this->logSlowQueries($queries);

        // Add performance headers in debug mode
        if (config('app.debug')) {
            $response->headers->set('X-Execution-Time', round($executionTime, 2) . 'ms');
            $response->headers->set('X-Query-Count', $queryCount);
            $response->headers->set('X-Memory-Used', round($memoryUsed, 2) . 'MB');
        }

        // Disable query logging
        DB::disableQueryLog();

        return $response;
    }

    /**
     * Log performance metrics.
     */
    protected function logPerformanceMetrics(Request $request, array $metrics): void
    {
        $logData = [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'metrics' => $metrics,
        ];

        // Only log to performance channel if execution time is notable
        if ($metrics['execution_time_ms'] > 100) {
            Log::channel('performance')->info('Request performance', $logData);
        }
    }

    /**
     * Log slow request details.
     */
    protected function logSlowRequest(Request $request, float $executionTime, array $queries): void
    {
        $slowQueries = array_filter($queries, fn($q) => $q['time'] > $this->slowQueryThreshold);

        Log::channel('performance')->warning('Slow request detected', [
            'url' => $request->fullUrl(),
            'method' => $request->method(),
            'execution_time_ms' => round($executionTime, 2),
            'query_count' => count($queries),
            'slow_queries' => array_map(fn($q) => [
                'sql' => $q['query'],
                'time_ms' => $q['time'],
            ], $slowQueries),
            'user_id' => auth()->id(),
        ]);
    }

    /**
     * Log individual slow queries.
     */
    protected function logSlowQueries(array $queries): void
    {
        foreach ($queries as $query) {
            if ($query['time'] > $this->slowQueryThreshold) {
                Log::channel('performance')->warning('Slow query detected', [
                    'sql' => $query['query'],
                    'bindings' => $query['bindings'],
                    'time_ms' => $query['time'],
                ]);
            }
        }
    }
}
