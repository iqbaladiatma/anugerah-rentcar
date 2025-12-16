<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Performance Monitoring Configuration
    |--------------------------------------------------------------------------
    |
    | Configure performance monitoring thresholds and caching behavior.
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Slow Request Threshold
    |--------------------------------------------------------------------------
    |
    | Requests taking longer than this threshold (in milliseconds) will be
    | logged as slow requests for investigation.
    |
    */
    'slow_request_threshold' => env('SLOW_REQUEST_THRESHOLD', 1000),

    /*
    |--------------------------------------------------------------------------
    | Slow Query Threshold
    |--------------------------------------------------------------------------
    |
    | Database queries taking longer than this threshold (in milliseconds)
    | will be logged as slow queries for optimization.
    |
    */
    'slow_query_threshold' => env('SLOW_QUERY_THRESHOLD', 100),

    /*
    |--------------------------------------------------------------------------
    | Query Logging
    |--------------------------------------------------------------------------
    |
    | Enable detailed query logging for performance analysis.
    | Should be disabled in production for performance.
    |
    */
    'log_queries' => env('LOG_QUERIES', false),

    /*
    |--------------------------------------------------------------------------
    | Cache Configuration
    |--------------------------------------------------------------------------
    |
    | Configure cache TTL values for different data types.
    | Values are in seconds.
    |
    */
    'cache' => [
        'settings' => env('CACHE_TTL_SETTINGS', 3600),      // 1 hour
        'fleet_stats' => env('CACHE_TTL_FLEET', 300),       // 5 minutes
        'dashboard' => env('CACHE_TTL_DASHBOARD', 60),      // 1 minute
        'availability' => env('CACHE_TTL_AVAILABILITY', 60), // 1 minute
        'reports' => env('CACHE_TTL_REPORTS', 3600),        // 1 hour
        'customers' => env('CACHE_TTL_CUSTOMERS', 300),     // 5 minutes
    ],

    /*
    |--------------------------------------------------------------------------
    | Pagination Defaults
    |--------------------------------------------------------------------------
    |
    | Default pagination settings for large datasets.
    |
    */
    'pagination' => [
        'default_per_page' => env('PAGINATION_DEFAULT', 15),
        'max_per_page' => env('PAGINATION_MAX', 100),
    ],

    /*
    |--------------------------------------------------------------------------
    | Lazy Loading Configuration
    |--------------------------------------------------------------------------
    |
    | Configure lazy loading behavior for large datasets.
    |
    */
    'lazy_loading' => [
        'chunk_size' => env('LAZY_LOAD_CHUNK_SIZE', 100),
        'enable_cursor_pagination' => env('ENABLE_CURSOR_PAGINATION', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Asset Optimization
    |--------------------------------------------------------------------------
    |
    | Configure asset optimization settings.
    |
    */
    'assets' => [
        'cdn_url' => env('CDN_URL', null),
        'enable_versioning' => env('ASSET_VERSIONING', true),
        'minify_html' => env('MINIFY_HTML', false),
    ],

    /*
    |--------------------------------------------------------------------------
    | Database Optimization
    |--------------------------------------------------------------------------
    |
    | Configure database optimization settings.
    |
    */
    'database' => [
        'enable_query_cache' => env('DB_QUERY_CACHE', true),
        'connection_pool_size' => env('DB_POOL_SIZE', 10),
        'statement_cache_size' => env('DB_STATEMENT_CACHE', 100),
    ],

];
