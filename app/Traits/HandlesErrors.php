<?php

namespace App\Traits;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\ApplicationLoggerService;
use App\Services\ErrorRecoveryService;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\DataIntegrityException;
use App\Exceptions\ExternalServiceException;
use Throwable;

trait HandlesErrors
{
    /**
     * Execute operation with comprehensive error handling.
     */
    protected function executeWithErrorHandling(
        callable $operation,
        string $operationName,
        array $context = [],
        array $recoveryOptions = []
    ): mixed {
        $logger = app(ApplicationLoggerService::class);
        $recovery = app(ErrorRecoveryService::class);
        
        $startTime = microtime(true);
        $transactionStarted = false;

        try {
            // Start transaction if specified
            if ($recoveryOptions['use_transaction'] ?? false) {
                DB::beginTransaction();
                $transactionStarted = true;
            }

            // Log operation start
            $logger->logBusinessOperation(
                $operationName,
                'started',
                $context
            );

            // Execute the operation
            $result = $operation();

            // Commit transaction if started
            if ($transactionStarted) {
                DB::commit();
                $transactionStarted = false;
            }

            // Log successful completion
            $executionTime = microtime(true) - $startTime;
            $logger->logBusinessOperation(
                $operationName,
                'success',
                array_merge($context, [
                    'execution_time' => $executionTime,
                    'memory_usage' => memory_get_usage(true),
                ])
            );

            return $result;

        } catch (Throwable $e) {
            // Rollback transaction if active
            if ($transactionStarted) {
                try {
                    DB::rollBack();
                } catch (Throwable $rollbackException) {
                    $logger->logSecurityEvent(
                        'transaction_rollback_failed',
                        'critical',
                        [
                            'operation' => $operationName,
                            'original_exception' => get_class($e),
                            'rollback_exception' => $rollbackException->getMessage(),
                        ]
                    );
                }
            }

            // Log the error
            $executionTime = microtime(true) - $startTime;
            $logger->logBusinessOperation(
                $operationName,
                'failed',
                array_merge($context, [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                    'execution_time' => $executionTime,
                ])
            );

            // Attempt recovery if enabled
            if ($recoveryOptions['enable_recovery'] ?? false) {
                try {
                    return $recovery->executeWithRecovery($operation, $recoveryOptions);
                } catch (Throwable $recoveryException) {
                    $logger->logBusinessOperation(
                        $operationName . '_recovery',
                        'failed',
                        [
                            'original_exception' => get_class($e),
                            'recovery_exception' => get_class($recoveryException),
                        ]
                    );
                }
            }

            // Re-throw the original exception
            throw $e;
        }
    }

    /**
     * Handle business logic validation with proper exception throwing.
     */
    protected function validateBusinessRules(array $rules, array $data, string $context = ''): void
    {
        $logger = app(ApplicationLoggerService::class);
        $violations = [];

        foreach ($rules as $rule => $validator) {
            try {
                if (!$validator($data)) {
                    $violations[] = $rule;
                }
            } catch (Throwable $e) {
                $logger->logBusinessOperation(
                    'business_rule_validation',
                    'error',
                    [
                        'rule' => $rule,
                        'context' => $context,
                        'exception' => get_class($e),
                        'message' => $e->getMessage(),
                    ]
                );
                $violations[] = $rule;
            }
        }

        if (!empty($violations)) {
            throw BusinessLogicException::invalidPricingParameters([
                'violated_rules' => $violations,
                'context' => $context,
                'provided_data' => $data,
            ]);
        }
    }

    /**
     * Safely execute database operations with integrity checks.
     */
    protected function executeDatabaseOperation(
        callable $operation,
        string $operationName,
        array $affectedTables = []
    ): mixed {
        $logger = app(ApplicationLoggerService::class);
        
        try {
            DB::beginTransaction();
            
            $result = $operation();
            
            // Verify data integrity after operation
            $this->verifyDataIntegrity($affectedTables);
            
            DB::commit();
            
            $logger->logDatabaseOperation(
                $operationName,
                implode(',', $affectedTables),
                null,
                ['status' => 'success']
            );
            
            return $result;
            
        } catch (Throwable $e) {
            DB::rollBack();
            
            $logger->logDatabaseOperation(
                $operationName,
                implode(',', $affectedTables),
                null,
                [
                    'status' => 'failed',
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                ]
            );
            
            // Convert database exceptions to our custom exceptions
            if ($this->isDatabaseIntegrityError($e)) {
                throw DataIntegrityException::foreignKeyViolation(
                    $affectedTables[0] ?? 'unknown',
                    'unknown',
                    null
                );
            }
            
            throw $e;
        }
    }

    /**
     * Handle external service calls with proper error handling.
     */
    protected function callExternalService(
        callable $serviceCall,
        string $serviceName,
        array $context = []
    ): mixed {
        $logger = app(ApplicationLoggerService::class);
        $recovery = app(ErrorRecoveryService::class);
        
        // Check if service is marked as unavailable
        if ($recovery->isServiceUnavailable($serviceName)) {
            throw ExternalServiceException::apiServiceUnavailable(
                $serviceName,
                'Service temporarily unavailable',
                503
            );
        }
        
        try {
            $startTime = microtime(true);
            
            $result = $serviceCall();
            
            $executionTime = microtime(true) - $startTime;
            $logger->logApiRequest(
                $serviceName,
                'CALL',
                $context,
                ['status' => 'success'],
                200,
                $executionTime
            );
            
            return $result;
            
        } catch (Throwable $e) {
            $executionTime = microtime(true) - $startTime;
            
            $logger->logApiRequest(
                $serviceName,
                'CALL',
                $context,
                [
                    'error' => $e->getMessage(),
                    'exception' => get_class($e),
                ],
                $e->getCode() ?: 500,
                $executionTime
            );
            
            // Convert to external service exception
            throw ExternalServiceException::apiServiceUnavailable(
                $serviceName,
                $serviceName,
                $e->getCode() ?: 500,
                $e->getMessage()
            );
        }
    }

    /**
     * Verify data integrity for specified tables.
     */
    protected function verifyDataIntegrity(array $tables): void
    {
        foreach ($tables as $table) {
            // Basic integrity checks - this would be expanded based on specific needs
            try {
                DB::table($table)->count();
            } catch (Throwable $e) {
                throw DataIntegrityException::dataCorruption(
                    $table,
                    'unknown',
                    ['verification_failed']
                );
            }
        }
    }

    /**
     * Check if exception indicates database integrity error.
     */
    protected function isDatabaseIntegrityError(Throwable $e): bool
    {
        $message = strtolower($e->getMessage());
        $integrityKeywords = [
            'foreign key constraint',
            'unique constraint',
            'duplicate entry',
            'cannot be null',
            'data too long',
        ];

        foreach ($integrityKeywords as $keyword) {
            if (strpos($message, $keyword) !== false) {
                return true;
            }
        }

        return false;
    }

    /**
     * Log user action with security context.
     */
    protected function logUserAction(
        string $action,
        ?string $resource = null,
        ?string $resourceId = null,
        array $additionalData = []
    ): void {
        $logger = app(ApplicationLoggerService::class);
        
        $logger->logUserActivity($action, $resource, $resourceId, $additionalData);
        
        // Log security-relevant actions
        $securityActions = [
            'login',
            'logout',
            'password_change',
            'permission_change',
            'data_export',
            'configuration_change',
        ];
        
        if (in_array($action, $securityActions)) {
            $logger->logSecurityEvent(
                $action,
                'medium',
                array_merge($additionalData, [
                    'resource' => $resource,
                    'resource_id' => $resourceId,
                ])
            );
        }
    }

    /**
     * Handle file operations with proper error handling.
     */
    protected function executeFileOperation(
        callable $operation,
        string $operationName,
        string $filePath
    ): mixed {
        $logger = app(ApplicationLoggerService::class);
        
        try {
            $result = $operation();
            
            $logger->logFileOperation(
                $operationName,
                $filePath,
                is_file($filePath) ? filesize($filePath) : null,
                is_file($filePath) ? mime_content_type($filePath) : null
            );
            
            return $result;
            
        } catch (Throwable $e) {
            $logger->logFileOperation(
                $operationName . '_failed',
                $filePath,
                null,
                null,
                [
                    'exception' => get_class($e),
                    'message' => $e->getMessage(),
                ]
            );
            
            throw $e;
        }
    }
}