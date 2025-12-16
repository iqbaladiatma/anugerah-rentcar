<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\ApplicationLoggerService;
use App\Services\ErrorRecoveryService;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class ErrorHandlingMiddleware
{
    protected ApplicationLoggerService $logger;
    protected ErrorRecoveryService $recovery;

    public function __construct(
        ApplicationLoggerService $logger,
        ErrorRecoveryService $recovery
    ) {
        $this->logger = $logger;
        $this->recovery = $recovery;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);
        $requestId = uniqid('req_');
        
        // Add request ID to headers for tracking
        $request->headers->set('X-Request-ID', $requestId);

        // Log incoming request
        $this->logIncomingRequest($request, $requestId);

        try {
            // Start database transaction for critical operations
            if ($this->shouldUseTransaction($request)) {
                DB::beginTransaction();
            }

            $response = $next($request);

            // Commit transaction if it was started
            if (DB::transactionLevel() > 0) {
                DB::commit();
            }

            // Log successful response
            $this->logSuccessfulResponse($request, $response, $startTime, $requestId);

            return $response;

        } catch (Throwable $e) {
            // Rollback transaction if active
            if (DB::transactionLevel() > 0) {
                try {
                    DB::rollBack();
                } catch (Throwable $rollbackException) {
                    $this->logger->logSecurityEvent(
                        'transaction_rollback_failed',
                        'critical',
                        [
                            'request_id' => $requestId,
                            'original_exception' => get_class($e),
                            'rollback_exception' => $rollbackException->getMessage(),
                        ]
                    );
                }
            }

            // Log the error
            $this->logRequestError($request, $e, $startTime, $requestId);

            // Attempt recovery if appropriate
            if ($this->shouldAttemptRecovery($e)) {
                try {
                    $this->recovery->executeWithRecovery(
                        function () use ($e) {
                            throw $e; // Re-throw to trigger recovery mechanisms
                        },
                        [
                            'max_attempts' => 1, // Don't retry in middleware
                            'enable_fallback' => true,
                            'create_missing_directories' => true,
                        ]
                    );
                } catch (Throwable $recoveryException) {
                    // Recovery failed, continue with original exception
                }
            }

            // Re-throw the exception to be handled by the exception handler
            throw $e;
        }
    }

    /**
     * Log incoming request details.
     */
    protected function logIncomingRequest(Request $request, string $requestId): void
    {
        $this->logger->createStructuredLog(
            'info',
            'Incoming Request',
            'request',
            [
                'request_id' => $requestId,
                'method' => $request->method(),
                'url' => $request->fullUrl(),
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'user_id' => auth()->id(),
                'route' => $request->route()?->getName(),
                'parameters' => $request->route()?->parameters(),
            ]
        );
    }

    /**
     * Log successful response.
     */
    protected function logSuccessfulResponse(
        Request $request,
        Response $response,
        float $startTime,
        string $requestId
    ): void {
        $executionTime = microtime(true) - $startTime;

        $this->logger->createStructuredLog(
            'info',
            'Request Completed',
            'response',
            [
                'request_id' => $requestId,
                'status_code' => $response->getStatusCode(),
                'execution_time' => $executionTime,
                'memory_usage' => memory_get_usage(true),
                'memory_peak' => memory_get_peak_usage(true),
            ]
        );

        // Log performance metrics for slow requests
        if ($executionTime > 2.0) {
            $this->logger->logPerformanceMetric(
                'slow_request',
                $executionTime,
                [
                    'request_id' => $requestId,
                    'url' => $request->fullUrl(),
                    'method' => $request->method(),
                    'threshold_exceeded' => '2_seconds',
                ]
            );
        }
    }

    /**
     * Log request error details.
     */
    protected function logRequestError(
        Request $request,
        Throwable $e,
        float $startTime,
        string $requestId
    ): void {
        $executionTime = microtime(true) - $startTime;

        $this->logger->createStructuredLog(
            'error',
            'Request Failed',
            'error',
            [
                'request_id' => $requestId,
                'exception' => get_class($e),
                'message' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'execution_time' => $executionTime,
                'memory_usage' => memory_get_usage(true),
                'request_data' => $this->sanitizeRequestData($request),
            ]
        );
    }

    /**
     * Determine if request should use database transaction.
     */
    protected function shouldUseTransaction(Request $request): bool
    {
        // Use transactions for state-changing operations
        $transactionMethods = ['POST', 'PUT', 'PATCH', 'DELETE'];
        
        if (!in_array($request->method(), $transactionMethods)) {
            return false;
        }

        // Skip transactions for file uploads and exports
        $skipRoutes = [
            'files.upload',
            'exports.download',
            'reports.export',
        ];

        $routeName = $request->route()?->getName();
        return !in_array($routeName, $skipRoutes);
    }

    /**
     * Determine if recovery should be attempted for this exception.
     */
    protected function shouldAttemptRecovery(Throwable $e): bool
    {
        // Don't attempt recovery for validation errors or client errors
        if ($e instanceof \Illuminate\Validation\ValidationException) {
            return false;
        }

        if (method_exists($e, 'getStatusCode') && $e->getStatusCode() < 500) {
            return false;
        }

        return true;
    }

    /**
     * Sanitize request data for logging.
     */
    protected function sanitizeRequestData(Request $request): array
    {
        $data = $request->all();
        
        $sensitiveFields = [
            'password',
            'password_confirmation',
            'current_password',
            '_token',
            'api_key',
            'secret',
        ];

        foreach ($sensitiveFields as $field) {
            if (isset($data[$field])) {
                $data[$field] = '[REDACTED]';
            }
        }

        return $data;
    }
}