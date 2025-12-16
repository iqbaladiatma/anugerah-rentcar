<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use App\Exceptions\DataIntegrityException;
use App\Exceptions\ExternalServiceException;
use Throwable;

class ErrorRecoveryService
{
    protected ApplicationLoggerService $logger;
    protected int $maxRetryAttempts = 3;
    protected array $retryableExceptions = [
        ExternalServiceException::class,
        'Illuminate\Http\Client\ConnectionException',
        'GuzzleHttp\Exception\ConnectException',
    ];

    public function __construct(ApplicationLoggerService $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Execute operation with automatic retry and recovery mechanisms.
     */
    public function executeWithRecovery(
        callable $operation,
        array $recoveryOptions = []
    ): mixed {
        $attempts = 0;
        $maxAttempts = $recoveryOptions['max_attempts'] ?? $this->maxRetryAttempts;
        $backoffMultiplier = $recoveryOptions['backoff_multiplier'] ?? 2;
        $initialDelay = $recoveryOptions['initial_delay'] ?? 1;

        while ($attempts < $maxAttempts) {
            try {
                $attempts++;
                
                $this->logger->logBusinessOperation(
                    'recovery_attempt',
                    'started',
                    ['attempt' => $attempts, 'max_attempts' => $maxAttempts]
                );

                $result = $operation();

                $this->logger->logBusinessOperation(
                    'recovery_attempt',
                    'success',
                    ['attempt' => $attempts, 'final_attempt' => true]
                );

                return $result;

            } catch (Throwable $e) {
                $this->logger->logBusinessOperation(
                    'recovery_attempt',
                    'failed',
                    [
                        'attempt' => $attempts,
                        'exception' => get_class($e),
                        'message' => $e->getMessage(),
                    ]
                );

                // Check if this exception is retryable
                if (!$this->isRetryableException($e) || $attempts >= $maxAttempts) {
                    // Attempt recovery strategies before giving up
                    $this->attemptRecoveryStrategies($e, $recoveryOptions);
                    throw $e;
                }

                // Calculate delay for next attempt
                $delay = $initialDelay * pow($backoffMultiplier, $attempts - 1);
                sleep($delay);
            }
        }

        throw new \RuntimeException('Maximum retry attempts exceeded');
    }

    /**
     * Check if an exception is retryable.
     */
    protected function isRetryableException(Throwable $e): bool
    {
        foreach ($this->retryableExceptions as $retryableClass) {
            if ($e instanceof $retryableClass) {
                return true;
            }
        }

        // Check for specific HTTP status codes that are retryable
        if (method_exists($e, 'getCode')) {
            $retryableCodes = [429, 500, 502, 503, 504];
            return in_array($e->getCode(), $retryableCodes);
        }

        return false;
    }

    /**
     * Attempt various recovery strategies based on exception type.
     */
    protected function attemptRecoveryStrategies(Throwable $e, array $options): void
    {
        $this->logger->logBusinessOperation(
            'recovery_strategy',
            'started',
            ['exception' => get_class($e)]
        );

        try {
            if ($e instanceof DataIntegrityException) {
                $this->recoverFromDataIntegrityError($e, $options);
            } elseif ($e instanceof ExternalServiceException) {
                $this->recoverFromExternalServiceError($e, $options);
            } elseif ($this->isDatabaseException($e)) {
                $this->recoverFromDatabaseError($e, $options);
            } elseif ($this->isFileSystemException($e)) {
                $this->recoverFromFileSystemError($e, $options);
            }

            $this->logger->logBusinessOperation(
                'recovery_strategy',
                'completed',
                ['exception' => get_class($e)]
            );

        } catch (Throwable $recoveryException) {
            $this->logger->logBusinessOperation(
                'recovery_strategy',
                'failed',
                [
                    'original_exception' => get_class($e),
                    'recovery_exception' => get_class($recoveryException),
                    'recovery_message' => $recoveryException->getMessage(),
                ]
            );
        }
    }

    /**
     * Recover from data integrity errors.
     */
    protected function recoverFromDataIntegrityError(DataIntegrityException $e, array $options): void
    {
        // Rollback any active transactions
        $this->rollbackAllTransactions();

        // Clear relevant caches that might contain stale data
        $this->clearRelatedCaches($e->getAffectedTables());

        // If backup restoration is enabled, attempt it
        if ($options['enable_backup_restore'] ?? false) {
            $this->attemptBackupRestore($e->getAffectedTables());
        }

        // Log the recovery attempt
        $this->logger->logSecurityEvent(
            'data_integrity_recovery',
            'high',
            [
                'affected_tables' => $e->getAffectedTables(),
                'recovery_suggestions' => $e->getRecoverySuggestions(),
            ]
        );
    }

    /**
     * Recover from external service errors.
     */
    protected function recoverFromExternalServiceError(ExternalServiceException $e, array $options): void
    {
        $serviceName = $e->getServiceName();

        // Mark service as temporarily unavailable
        $this->markServiceUnavailable($serviceName, $e->getRetryAfter());

        // Attempt fallback mechanisms
        if ($options['enable_fallback'] ?? true) {
            $this->enableServiceFallback($serviceName);
        }

        // Clear service-related caches
        Cache::tags(["service:{$serviceName}"])->flush();

        $this->logger->logBusinessOperation(
            'external_service_recovery',
            'attempted',
            [
                'service' => $serviceName,
                'retry_after' => $e->getRetryAfter(),
                'fallback_enabled' => $options['enable_fallback'] ?? false,
            ]
        );
    }

    /**
     * Recover from database errors.
     */
    protected function recoverFromDatabaseError(Throwable $e, array $options): void
    {
        // Rollback transactions
        $this->rollbackAllTransactions();

        // Clear query cache
        if (config('database.redis.cache')) {
            Cache::tags(['database', 'queries'])->flush();
        }

        // Attempt to reconnect to database
        try {
            DB::reconnect();
            $this->logger->logBusinessOperation(
                'database_recovery',
                'reconnection_success',
                ['exception' => get_class($e)]
            );
        } catch (Throwable $reconnectException) {
            $this->logger->logBusinessOperation(
                'database_recovery',
                'reconnection_failed',
                [
                    'original_exception' => get_class($e),
                    'reconnect_exception' => $reconnectException->getMessage(),
                ]
            );
        }
    }

    /**
     * Recover from file system errors.
     */
    protected function recoverFromFileSystemError(Throwable $e, array $options): void
    {
        // Clear file system caches
        Cache::tags(['filesystem', 'files'])->flush();

        // Attempt to create missing directories
        if ($options['create_missing_directories'] ?? true) {
            $this->createMissingDirectories();
        }

        // Check disk space and clean up if necessary
        if ($options['cleanup_on_space_error'] ?? true) {
            $this->cleanupTemporaryFiles();
        }

        $this->logger->logBusinessOperation(
            'filesystem_recovery',
            'attempted',
            ['exception' => get_class($e)]
        );
    }

    /**
     * Rollback all active database transactions.
     */
    protected function rollbackAllTransactions(): void
    {
        try {
            $transactionLevel = DB::transactionLevel();
            
            while (DB::transactionLevel() > 0) {
                DB::rollBack();
            }

            if ($transactionLevel > 0) {
                $this->logger->logDatabaseOperation(
                    'transaction_rollback',
                    'system',
                    null,
                    ['rolled_back_levels' => $transactionLevel]
                );
            }

        } catch (Throwable $e) {
            $this->logger->logSecurityEvent(
                'transaction_rollback_failed',
                'critical',
                ['error' => $e->getMessage()]
            );
        }
    }

    /**
     * Clear caches related to affected tables.
     */
    protected function clearRelatedCaches(array $tables): void
    {
        foreach ($tables as $table) {
            Cache::tags(["table:{$table}", 'database'])->flush();
        }

        $this->logger->logBusinessOperation(
            'cache_cleanup',
            'completed',
            ['affected_tables' => $tables]
        );
    }

    /**
     * Mark external service as temporarily unavailable.
     */
    public function markServiceUnavailable(string $serviceName, ?int $retryAfter): void
    {
        $cacheKey = "service_unavailable:{$serviceName}";
        $ttl = $retryAfter ? now()->addSeconds($retryAfter) : now()->addMinutes(15);
        
        Cache::put($cacheKey, true, $ttl);
    }

    /**
     * Enable fallback mechanisms for a service.
     */
    protected function enableServiceFallback(string $serviceName): void
    {
        $fallbackKey = "service_fallback:{$serviceName}";
        Cache::put($fallbackKey, true, now()->addHour());

        $this->logger->logBusinessOperation(
            'service_fallback',
            'enabled',
            ['service' => $serviceName]
        );
    }

    /**
     * Check if exception is database-related.
     */
    protected function isDatabaseException(Throwable $e): bool
    {
        $databaseExceptions = [
            'Illuminate\Database\QueryException',
            'PDOException',
            'Doctrine\DBAL\Exception',
        ];

        foreach ($databaseExceptions as $exceptionClass) {
            if ($e instanceof $exceptionClass) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if exception is file system-related.
     */
    protected function isFileSystemException(Throwable $e): bool
    {
        $message = strtolower($e->getMessage());
        $fileSystemKeywords = [
            'no such file',
            'permission denied',
            'disk full',
            'file not found',
            'directory not found',
        ];

        foreach ($fileSystemKeywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Create missing directories.
     */
    protected function createMissingDirectories(): void
    {
        $directories = [
            storage_path('app/temp'),
            storage_path('app/exports'),
            storage_path('app/quarantine'),
            storage_path('logs'),
        ];

        foreach ($directories as $directory) {
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
                $this->logger->logFileOperation(
                    'directory_created',
                    $directory
                );
            }
        }
    }

    /**
     * Clean up temporary files to free disk space.
     */
    protected function cleanupTemporaryFiles(): void
    {
        $tempDirectories = [
            storage_path('app/temp'),
            storage_path('framework/cache'),
            storage_path('framework/sessions'),
        ];

        foreach ($tempDirectories as $directory) {
            if (is_dir($directory)) {
                $this->cleanupOldFiles($directory, 24); // Clean files older than 24 hours
            }
        }
    }

    /**
     * Clean up old files in a directory.
     */
    protected function cleanupOldFiles(string $directory, int $hoursOld): void
    {
        $cutoffTime = time() - ($hoursOld * 3600);
        $files = glob($directory . '/*');

        foreach ($files as $file) {
            if (is_file($file) && filemtime($file) < $cutoffTime) {
                unlink($file);
                $this->logger->logFileOperation(
                    'temp_file_cleanup',
                    $file
                );
            }
        }
    }

    /**
     * Attempt to restore from backup (placeholder for actual implementation).
     */
    protected function attemptBackupRestore(array $affectedTables): void
    {
        // This would implement actual backup restoration logic
        // For now, just log the attempt
        $this->logger->logSecurityEvent(
            'backup_restore_attempted',
            'high',
            ['affected_tables' => $affectedTables]
        );
    }

    /**
     * Check if a service is currently marked as unavailable.
     */
    public function isServiceUnavailable(string $serviceName): bool
    {
        return Cache::has("service_unavailable:{$serviceName}");
    }

    /**
     * Check if fallback is enabled for a service.
     */
    public function isFallbackEnabled(string $serviceName): bool
    {
        return Cache::has("service_fallback:{$serviceName}");
    }
}