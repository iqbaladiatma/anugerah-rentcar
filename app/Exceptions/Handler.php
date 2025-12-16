<?php

namespace App\Exceptions;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use App\Services\ErrorNotificationService;
use Throwable;

class Handler
{
    /**
     * Report an exception.
     */
    public function report(Throwable $e): void
    {
        $this->logException($e);
        
        // Notify administrators for critical errors
        if ($this->shouldNotifyAdministrators($e)) {
            $this->notifyAdministrators($e);
        }
    }

    /**
     * Log exception with comprehensive context information.
     */
    protected function logException(Throwable $e): void
    {
        $context = [
            'exception' => get_class($e),
            'message' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'ip' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'user_id' => auth()->id(),
            'timestamp' => now()->toISOString(),
        ];

        // Add request data for non-GET requests
        if (request()->method() !== 'GET') {
            $context['request_data'] = request()->except(['password', 'password_confirmation', '_token']);
        }

        // Add database transaction status if available
        try {
            $context['db_transaction_level'] = DB::transactionLevel();
        } catch (\Exception $dbException) {
            $context['db_status'] = 'unavailable';
        }

        Log::error('Application Exception', $context);
    }

    /**
     * Determine if administrators should be notified about this exception.
     */
    protected function shouldNotifyAdministrators(Throwable $e): bool
    {
        // Don't notify for validation errors or 404s
        if ($e instanceof ValidationException || 
            ($e instanceof HttpException && $e->getStatusCode() === 404)) {
            return false;
        }

        // Notify for critical exceptions
        return $e instanceof DataIntegrityException ||
               $e instanceof QueryException ||
               (is_int($e->getCode()) && $e->getCode() >= 500);
    }

    /**
     * Notify administrators about critical errors.
     */
    protected function notifyAdministrators(Throwable $e): void
    {
        try {
            app(ErrorNotificationService::class)->notifyAdministrators($e);
        } catch (\Exception $notificationException) {
            Log::error('Failed to send error notification', [
                'original_exception' => get_class($e),
                'notification_exception' => $notificationException->getMessage(),
            ]);
        }
    }

    /**
     * Rollback any active database transactions.
     */
    public function rollbackTransactions(): void
    {
        try {
            while (DB::transactionLevel() > 0) {
                DB::rollBack();
                Log::info('Transaction rolled back due to exception', [
                    'remaining_levels' => DB::transactionLevel(),
                ]);
            }
        } catch (\Exception $rollbackException) {
            Log::error('Failed to rollback transaction', [
                'error' => $rollbackException->getMessage(),
            ]);
        }
    }
}