<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Http\Request;

class ApplicationLoggerService
{
    protected array $sensitiveFields = [
        'password',
        'password_confirmation',
        'current_password',
        '_token',
        'api_key',
        'secret',
        'credit_card',
        'ssn',
        'nik',
    ];

    /**
     * Log user activity with context.
     */
    public function logUserActivity(
        string $action,
        ?string $resource = null,
        ?string $resourceId = null,
        array $additionalData = []
    ): void {
        $context = [
            'user_id' => auth()->id(),
            'user_email' => auth()->user()?->email,
            'action' => $action,
            'resource' => $resource,
            'resource_id' => $resourceId,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'session_id' => session()->getId(),
            'timestamp' => now()->toISOString(),
        ];

        // Add sanitized additional data
        if (!empty($additionalData)) {
            $context['additional_data'] = $this->sanitizeData($additionalData);
        }

        Log::channel('activity')->info("User Activity: {$action}", $context);
    }

    /**
     * Log business operations with detailed context.
     */
    public function logBusinessOperation(
        string $operation,
        string $status,
        array $data = [],
        ?string $transactionId = null
    ): void {
        $context = [
            'operation' => $operation,
            'status' => $status,
            'transaction_id' => $transactionId,
            'user_id' => auth()->id(),
            'timestamp' => now()->toISOString(),
            'execution_time' => $this->getExecutionTime(),
            'memory_usage' => memory_get_usage(true),
        ];

        if (!empty($data)) {
            $context['operation_data'] = $this->sanitizeData($data);
        }

        $logLevel = $status === 'success' ? 'info' : 'warning';
        Log::channel('business')->{$logLevel}("Business Operation: {$operation}", $context);
    }

    /**
     * Log security events.
     */
    public function logSecurityEvent(
        string $event,
        string $severity = 'medium',
        array $details = []
    ): void {
        $context = [
            'event' => $event,
            'severity' => $severity,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'url' => request()->fullUrl(),
            'timestamp' => now()->toISOString(),
        ];

        if (!empty($details)) {
            $context['details'] = $this->sanitizeData($details);
        }

        // Use appropriate log level based on severity
        $logLevel = match ($severity) {
            'critical' => 'emergency',
            'high' => 'alert',
            'medium' => 'warning',
            'low' => 'notice',
            default => 'info',
        };

        Log::channel('security')->{$logLevel}("Security Event: {$event}", $context);

        // Cache security events for monitoring
        $this->cacheSecurityEvent($event, $severity, $context);
    }

    /**
     * Log performance metrics.
     */
    public function logPerformanceMetric(
        string $operation,
        float $executionTime,
        array $metrics = []
    ): void {
        $context = [
            'operation' => $operation,
            'execution_time' => $executionTime,
            'memory_usage' => memory_get_usage(true),
            'memory_peak' => memory_get_peak_usage(true),
            'timestamp' => now()->toISOString(),
        ];

        if (!empty($metrics)) {
            $context['metrics'] = $metrics;
        }

        Log::channel('performance')->info("Performance Metric: {$operation}", $context);
    }

    /**
     * Log database operations with query details.
     */
    public function logDatabaseOperation(
        string $operation,
        string $table,
        ?string $recordId = null,
        array $changes = [],
        ?float $queryTime = null
    ): void {
        $context = [
            'operation' => $operation,
            'table' => $table,
            'record_id' => $recordId,
            'user_id' => auth()->id(),
            'timestamp' => now()->toISOString(),
            'transaction_level' => DB::transactionLevel(),
        ];

        if (!empty($changes)) {
            $context['changes'] = $this->sanitizeData($changes);
        }

        if ($queryTime !== null) {
            $context['query_time'] = $queryTime;
        }

        Log::channel('database')->info("Database Operation: {$operation}", $context);
    }

    /**
     * Log API requests and responses.
     */
    public function logApiRequest(
        string $endpoint,
        string $method,
        array $requestData = [],
        ?array $responseData = null,
        ?int $statusCode = null,
        ?float $responseTime = null
    ): void {
        $context = [
            'endpoint' => $endpoint,
            'method' => $method,
            'status_code' => $statusCode,
            'response_time' => $responseTime,
            'user_id' => auth()->id(),
            'ip_address' => request()->ip(),
            'timestamp' => now()->toISOString(),
        ];

        if (!empty($requestData)) {
            $context['request_data'] = $this->sanitizeData($requestData);
        }

        if ($responseData !== null) {
            $context['response_data'] = $this->sanitizeData($responseData);
        }

        Log::channel('api')->info("API Request: {$method} {$endpoint}", $context);
    }

    /**
     * Log file operations.
     */
    public function logFileOperation(
        string $operation,
        string $filePath,
        ?int $fileSize = null,
        ?string $mimeType = null,
        array $metadata = []
    ): void {
        $context = [
            'operation' => $operation,
            'file_path' => $filePath,
            'file_size' => $fileSize,
            'mime_type' => $mimeType,
            'user_id' => auth()->id(),
            'timestamp' => now()->toISOString(),
        ];

        if (!empty($metadata)) {
            $context['metadata'] = $metadata;
        }

        Log::channel('files')->info("File Operation: {$operation}", $context);
    }

    /**
     * Log system configuration changes.
     */
    public function logConfigurationChange(
        string $setting,
        mixed $oldValue,
        mixed $newValue,
        ?string $reason = null
    ): void {
        $context = [
            'setting' => $setting,
            'old_value' => $this->sanitizeValue($oldValue),
            'new_value' => $this->sanitizeValue($newValue),
            'reason' => $reason,
            'user_id' => auth()->id(),
            'user_email' => auth()->user()?->email,
            'ip_address' => request()->ip(),
            'timestamp' => now()->toISOString(),
        ];

        Log::channel('configuration')->warning("Configuration Change: {$setting}", $context);
    }

    /**
     * Sanitize data by removing sensitive information.
     */
    protected function sanitizeData(array $data): array
    {
        $sanitized = [];

        foreach ($data as $key => $value) {
            if (in_array(strtolower($key), $this->sensitiveFields)) {
                $sanitized[$key] = '[REDACTED]';
            } elseif (is_array($value)) {
                $sanitized[$key] = $this->sanitizeData($value);
            } else {
                $sanitized[$key] = $this->sanitizeValue($value);
            }
        }

        return $sanitized;
    }

    /**
     * Sanitize individual values.
     */
    protected function sanitizeValue(mixed $value): mixed
    {
        if (is_string($value)) {
            // Redact potential sensitive patterns
            $patterns = [
                '/\b\d{4}[\s-]?\d{4}[\s-]?\d{4}[\s-]?\d{4}\b/', // Credit card numbers
                '/\b\d{3}-\d{2}-\d{4}\b/', // SSN pattern
                '/\b[A-Za-z0-9._%+-]+@[A-Za-z0-9.-]+\.[A-Z|a-z]{2,}\b/', // Email addresses in some contexts
            ];

            foreach ($patterns as $pattern) {
                if (preg_match($pattern, $value)) {
                    return '[REDACTED_PATTERN]';
                }
            }
        }

        return $value;
    }

    /**
     * Get current execution time.
     */
    protected function getExecutionTime(): float
    {
        if (defined('LARAVEL_START')) {
            return microtime(true) - LARAVEL_START;
        }
        return 0.0;
    }

    /**
     * Cache security events for monitoring.
     */
    protected function cacheSecurityEvent(string $event, string $severity, array $context): void
    {
        $cacheKey = "security_events:" . date('Y-m-d-H');
        $events = Cache::get($cacheKey, []);
        
        $events[] = [
            'event' => $event,
            'severity' => $severity,
            'timestamp' => $context['timestamp'],
            'user_id' => $context['user_id'] ?? null,
            'ip_address' => $context['ip_address'] ?? null,
        ];

        // Keep only last 100 events per hour
        if (count($events) > 100) {
            $events = array_slice($events, -100);
        }

        Cache::put($cacheKey, $events, now()->addHours(24));
    }

    /**
     * Get recent security events from cache.
     */
    public function getRecentSecurityEvents(int $hours = 1): array
    {
        $events = [];
        
        for ($i = 0; $i < $hours; $i++) {
            $cacheKey = "security_events:" . now()->subHours($i)->format('Y-m-d-H');
            $hourlyEvents = Cache::get($cacheKey, []);
            $events = array_merge($events, $hourlyEvents);
        }

        // Sort by timestamp descending
        usort($events, function ($a, $b) {
            return strtotime($b['timestamp']) - strtotime($a['timestamp']);
        });

        return $events;
    }

    /**
     * Create structured log entry with full context.
     */
    public function createStructuredLog(
        string $level,
        string $message,
        string $category,
        array $context = []
    ): void {
        $structuredContext = [
            'category' => $category,
            'user_id' => auth()->id(),
            'session_id' => session()->getId(),
            'request_id' => request()->header('X-Request-ID', uniqid()),
            'ip_address' => request()->ip(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'timestamp' => now()->toISOString(),
            'environment' => app()->environment(),
        ];

        if (!empty($context)) {
            $structuredContext['context'] = $this->sanitizeData($context);
        }

        Log::{$level}($message, $structuredContext);
    }
}