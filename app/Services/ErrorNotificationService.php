<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use App\Models\User;
use App\Models\Notification;
use App\Notifications\SystemNotification;
use Throwable;

class ErrorNotificationService
{
    protected int $notificationThrottleMinutes = 15;
    protected array $criticalExceptionTypes = [
        'App\Exceptions\DataIntegrityException',
        'Illuminate\Database\QueryException',
        'PDOException',
    ];

    /**
     * Notify administrators about critical system errors.
     */
    public function notifyAdministrators(Throwable $exception): void
    {
        // Check if we should throttle notifications for this exception type
        if ($this->shouldThrottleNotification($exception)) {
            Log::info('Error notification throttled', [
                'exception' => get_class($exception),
                'message' => $exception->getMessage(),
            ]);
            return;
        }

        $errorData = $this->prepareErrorData($exception);
        
        // Get all admin users
        $administrators = User::where('role', 'admin')->get();

        foreach ($administrators as $admin) {
            try {
                $this->sendErrorNotification($admin, $errorData);
                $this->createDatabaseNotification($admin, $errorData);
            } catch (\Exception $e) {
                Log::error('Failed to send error notification to admin', [
                    'admin_id' => $admin->id,
                    'error' => $e->getMessage(),
                    'original_exception' => get_class($exception),
                ]);
            }
        }

        // Mark this exception type as notified to prevent spam
        $this->markNotificationSent($exception);
    }

    /**
     * Check if notifications should be throttled for this exception.
     */
    protected function shouldThrottleNotification(Throwable $exception): bool
    {
        $cacheKey = $this->getThrottleCacheKey($exception);
        return Cache::has($cacheKey);
    }

    /**
     * Mark that a notification has been sent for this exception type.
     */
    protected function markNotificationSent(Throwable $exception): void
    {
        $cacheKey = $this->getThrottleCacheKey($exception);
        Cache::put($cacheKey, true, now()->addMinutes($this->notificationThrottleMinutes));
    }

    /**
     * Generate cache key for throttling notifications.
     */
    protected function getThrottleCacheKey(Throwable $exception): string
    {
        $exceptionClass = get_class($exception);
        $messageHash = md5($exception->getMessage());
        return "error_notification_throttle:{$exceptionClass}:{$messageHash}";
    }

    /**
     * Prepare error data for notifications.
     */
    protected function prepareErrorData(Throwable $exception): array
    {
        $severity = $this->determineSeverity($exception);
        
        return [
            'severity' => $severity,
            'exception_class' => get_class($exception),
            'message' => $exception->getMessage(),
            'file' => $exception->getFile(),
            'line' => $exception->getLine(),
            'url' => request()->fullUrl(),
            'method' => request()->method(),
            'user_id' => auth()->id(),
            'user_email' => auth()->user()?->email,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'timestamp' => now()->toISOString(),
            'environment' => app()->environment(),
            'stack_trace' => $this->formatStackTrace($exception),
            'request_data' => $this->sanitizeRequestData(),
            'system_info' => $this->getSystemInfo(),
        ];
    }

    /**
     * Determine the severity level of the exception.
     */
    protected function determineSeverity(Throwable $exception): string
    {
        $exceptionClass = get_class($exception);

        if (in_array($exceptionClass, $this->criticalExceptionTypes)) {
            return 'critical';
        }

        if ($exception->getCode() >= 500) {
            return 'high';
        }

        if ($exception->getCode() >= 400) {
            return 'medium';
        }

        return 'low';
    }

    /**
     * Format stack trace for readability.
     */
    protected function formatStackTrace(Throwable $exception): array
    {
        $trace = $exception->getTrace();
        $formattedTrace = [];

        foreach (array_slice($trace, 0, 10) as $index => $frame) {
            $formattedTrace[] = [
                'index' => $index,
                'file' => $frame['file'] ?? 'unknown',
                'line' => $frame['line'] ?? 'unknown',
                'function' => $frame['function'] ?? 'unknown',
                'class' => $frame['class'] ?? null,
            ];
        }

        return $formattedTrace;
    }

    /**
     * Sanitize request data for logging.
     */
    protected function sanitizeRequestData(): array
    {
        $data = request()->all();
        
        // Remove sensitive fields
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

    /**
     * Get system information for debugging.
     */
    protected function getSystemInfo(): array
    {
        return [
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version(),
            'memory_usage' => memory_get_usage(true),
            'memory_peak' => memory_get_peak_usage(true),
            'server_time' => date('Y-m-d H:i:s'),
            'timezone' => config('app.timezone'),
        ];
    }

    /**
     * Send email notification to administrator.
     */
    protected function sendErrorNotification(User $admin, array $errorData): void
    {
        $subject = sprintf(
            '[%s] %s Error: %s',
            strtoupper($errorData['environment']),
            ucfirst($errorData['severity']),
            $errorData['exception_class']
        );

        $notificationData = [
            'type' => 'system_error',
            'title' => $subject,
            'message' => $this->formatErrorMessage($errorData),
            'data' => $errorData,
            'action_url' => route('admin.dashboard'),
            'action_text' => 'View Dashboard',
        ];

        $admin->notify(new SystemNotification($notificationData));
    }

    /**
     * Create database notification for the error.
     */
    protected function createDatabaseNotification(User $admin, array $errorData): void
    {
        Notification::create([
            'user_id' => $admin->id,
            'type' => 'system_error',
            'title' => sprintf('%s System Error', ucfirst($errorData['severity'])),
            'message' => $this->formatErrorMessage($errorData),
            'data' => json_encode($errorData),
            'is_read' => false,
            'created_at' => now(),
        ]);
    }

    /**
     * Format error message for notifications.
     */
    protected function formatErrorMessage(array $errorData): string
    {
        $message = "A {$errorData['severity']} error occurred in the system:\n\n";
        $message .= "Exception: {$errorData['exception_class']}\n";
        $message .= "Message: {$errorData['message']}\n";
        $message .= "Location: {$errorData['file']}:{$errorData['line']}\n";
        $message .= "URL: {$errorData['url']}\n";
        $message .= "Time: {$errorData['timestamp']}\n";

        if ($errorData['user_id']) {
            $message .= "User: {$errorData['user_email']} (ID: {$errorData['user_id']})\n";
        }

        $message .= "\nPlease investigate this issue promptly.";

        return $message;
    }

    /**
     * Send immediate notification for critical errors.
     */
    public function sendCriticalErrorAlert(Throwable $exception): void
    {
        // For critical errors, bypass throttling and send immediately
        $errorData = $this->prepareErrorData($exception);
        $errorData['severity'] = 'critical';

        $administrators = User::where('role', 'admin')->get();

        foreach ($administrators as $admin) {
            try {
                $this->sendErrorNotification($admin, $errorData);
                $this->createDatabaseNotification($admin, $errorData);
                
                // Also log to a special critical errors log
                Log::channel('critical')->error('CRITICAL ERROR ALERT', $errorData);
            } catch (\Exception $e) {
                // If we can't send notifications, at least log it
                Log::emergency('Failed to send critical error notification', [
                    'admin_id' => $admin->id,
                    'notification_error' => $e->getMessage(),
                    'original_exception' => get_class($exception),
                    'original_message' => $exception->getMessage(),
                ]);
            }
        }
    }

    /**
     * Get error statistics for dashboard.
     */
    public function getErrorStatistics(int $hours = 24): array
    {
        $since = now()->subHours($hours);
        
        // This would typically query a dedicated error log table
        // For now, we'll return a basic structure
        return [
            'total_errors' => 0,
            'critical_errors' => 0,
            'high_priority_errors' => 0,
            'medium_priority_errors' => 0,
            'low_priority_errors' => 0,
            'most_common_exceptions' => [],
            'error_trend' => [],
            'affected_users' => 0,
        ];
    }
}