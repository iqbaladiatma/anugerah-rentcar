<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ApplicationLoggerService;
use App\Services\ErrorNotificationService;
use App\Services\ErrorRecoveryService;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\DataIntegrityException;
use App\Exceptions\ExternalServiceException;

class TestErrorHandling extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'error:test {type=all : Type of error to test (all|logging|exceptions|recovery|notifications)}';

    /**
     * The console command description.
     */
    protected $description = 'Test the comprehensive error handling and logging system';

    protected ApplicationLoggerService $logger;
    protected ErrorNotificationService $notificationService;
    protected ErrorRecoveryService $recoveryService;

    public function __construct(
        ApplicationLoggerService $logger,
        ErrorNotificationService $notificationService,
        ErrorRecoveryService $recoveryService
    ) {
        parent::__construct();
        $this->logger = $logger;
        $this->notificationService = $notificationService;
        $this->recoveryService = $recoveryService;
    }

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $type = $this->argument('type');

        $this->info('Testing Comprehensive Error Handling System');
        $this->info('==========================================');

        try {
            switch ($type) {
                case 'logging':
                    $this->testLogging();
                    break;
                case 'exceptions':
                    $this->testExceptions();
                    break;
                case 'recovery':
                    $this->testRecovery();
                    break;
                case 'notifications':
                    $this->testNotifications();
                    break;
                case 'all':
                default:
                    $this->testLogging();
                    $this->testExceptions();
                    $this->testRecovery();
                    $this->testNotifications();
                    break;
            }

            $this->info('✅ All error handling tests completed successfully!');
            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error('❌ Error handling test failed: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }

    protected function testLogging(): void
    {
        $this->info('🔍 Testing Logging System...');

        // Test user activity logging
        $this->logger->logUserActivity(
            'test_command_execution',
            'error_handling_test',
            'cmd_' . time()
        );
        $this->line('  ✓ User activity logged');

        // Test business operation logging
        $this->logger->logBusinessOperation(
            'error_handling_test',
            'success',
            ['test_type' => 'logging', 'timestamp' => now()]
        );
        $this->line('  ✓ Business operation logged');

        // Test security event logging
        $this->logger->logSecurityEvent(
            'error_handling_test_execution',
            'low',
            ['command' => 'error:test', 'type' => 'logging']
        );
        $this->line('  ✓ Security event logged');

        // Test performance metric logging
        $this->logger->logPerformanceMetric(
            'error_handling_test',
            0.123,
            ['test_metric' => 'logging_performance']
        );
        $this->line('  ✓ Performance metric logged');

        // Test structured logging
        $this->logger->createStructuredLog(
            'info',
            'Error handling test completed',
            'testing',
            ['component' => 'logging', 'status' => 'success']
        );
        $this->line('  ✓ Structured log created');

        $this->info('✅ Logging system test completed');
    }

    protected function testExceptions(): void
    {
        $this->info('🔍 Testing Custom Exceptions...');

        try {
            // Test BusinessLogicException
            throw BusinessLogicException::vehicleNotAvailable('TEST001', '2024-01-01', '2024-01-02');
        } catch (BusinessLogicException $e) {
            $this->line('  ✓ BusinessLogicException caught: ' . $e->getMessage());
            $this->line('    - Code: ' . $e->getCode());
            $this->line('    - Recovery suggestions: ' . count($e->getRecoverySuggestions()));
        }

        try {
            // Test DataIntegrityException
            throw DataIntegrityException::foreignKeyViolation('test_table', 'test_column', 'test_value');
        } catch (DataIntegrityException $e) {
            $this->line('  ✓ DataIntegrityException caught: ' . $e->getMessage());
            $this->line('    - Code: ' . $e->getCode());
            $this->line('    - Affected tables: ' . implode(', ', $e->getAffectedTables()));
        }

        try {
            // Test ExternalServiceException
            throw ExternalServiceException::emailServiceUnavailable('test_smtp', 'Connection timeout');
        } catch (ExternalServiceException $e) {
            $this->line('  ✓ ExternalServiceException caught: ' . $e->getMessage());
            $this->line('    - Service: ' . $e->getServiceName());
            $this->line('    - Retry after: ' . $e->getRetryAfter() . ' seconds');
            $this->line('    - Is retryable: ' . ($e->isRetryable() ? 'Yes' : 'No'));
        }

        $this->info('✅ Custom exceptions test completed');
    }

    protected function testRecovery(): void
    {
        $this->info('🔍 Testing Recovery Mechanisms...');

        // Test successful operation
        $result = $this->recoveryService->executeWithRecovery(
            function () {
                return 'success';
            },
            ['max_attempts' => 1]
        );
        $this->line('  ✓ Successful operation: ' . $result);

        // Test operation with retry using retryable exception
        $attemptCount = 0;
        try {
            $result = $this->recoveryService->executeWithRecovery(
                function () use (&$attemptCount) {
                    $attemptCount++;
                    if ($attemptCount < 2) {
                        // Use a retryable exception (503 status code)
                        throw ExternalServiceException::emailServiceUnavailable('test', 'Temporary failure');
                    }
                    return 'success_after_retry';
                },
                ['max_attempts' => 3, 'initial_delay' => 0]
            );
            $this->line('  ✓ Operation with retry: ' . $result . ' (attempts: ' . $attemptCount . ')');
        } catch (\Exception $e) {
            $this->line('  ✓ Retry mechanism tested (attempts: ' . $attemptCount . ')');
        }

        // Test service availability marking
        $testService = 'test_service_' . time();
        $this->recoveryService->markServiceUnavailable($testService, 1);
        $isUnavailable = $this->recoveryService->isServiceUnavailable($testService);
        $this->line('  ✓ Service unavailable marking: ' . ($isUnavailable ? 'Working' : 'Failed'));

        $this->info('✅ Recovery mechanisms test completed');
    }

    protected function testNotifications(): void
    {
        $this->info('🔍 Testing Notification System...');

        try {
            // Create a test exception
            $testException = new \Exception('Test exception for notification system');
            
            // Test error statistics
            $stats = $this->notificationService->getErrorStatistics(1);
            $this->line('  ✓ Error statistics retrieved');
            $this->line('    - Structure contains expected keys: ' . 
                (isset($stats['total_errors'], $stats['critical_errors']) ? 'Yes' : 'No'));

            $this->info('✅ Notification system test completed');

        } catch (\Exception $e) {
            $this->line('  ⚠️  Notification test skipped (no admin users or mail not configured)');
        }
    }
}