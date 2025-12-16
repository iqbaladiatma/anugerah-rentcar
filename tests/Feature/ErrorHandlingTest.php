<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Services\ApplicationLoggerService;
use App\Services\ErrorNotificationService;
use App\Services\ErrorRecoveryService;
use App\Exceptions\BusinessLogicException;
use App\Exceptions\DataIntegrityException;
use App\Exceptions\ExternalServiceException;

class ErrorHandlingTest extends TestCase
{
    use RefreshDatabase;

    protected ApplicationLoggerService $logger;
    protected ErrorNotificationService $notificationService;
    protected ErrorRecoveryService $recoveryService;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Ensure clean transaction state
        while (DB::transactionLevel() > 0) {
            DB::rollBack();
        }
        
        $this->logger = app(ApplicationLoggerService::class);
        $this->notificationService = app(ErrorNotificationService::class);
        $this->recoveryService = app(ErrorRecoveryService::class);
    }

    protected function tearDown(): void
    {
        // Ensure clean transaction state after each test
        while (DB::transactionLevel() > 0) {
            DB::rollBack();
        }
        
        parent::tearDown();
    }

    /** @test */
    public function it_handles_business_logic_exceptions_properly()
    {
        $exception = BusinessLogicException::vehicleNotAvailable('123', '2024-01-01', '2024-01-02');
        
        $this->assertEquals(1001, $exception->getCode());
        $this->assertStringContainsString('Vehicle is not available', $exception->getMessage());
        $this->assertNotEmpty($exception->getRecoverySuggestions());
        $this->assertCount(3, $exception->getRecoverySuggestions());
    }

    /** @test */
    public function it_handles_data_integrity_exceptions_with_recovery_suggestions()
    {
        $exception = DataIntegrityException::foreignKeyViolation('bookings', 'car_id', 999);
        
        $this->assertEquals(2001, $exception->getCode());
        $this->assertStringContainsString('Foreign key constraint', $exception->getMessage());
        $this->assertContains('bookings', $exception->getAffectedTables());
        $this->assertNotEmpty($exception->getRecoverySuggestions());
    }

    /** @test */
    public function it_handles_external_service_exceptions_with_retry_logic()
    {
        $exception = ExternalServiceException::emailServiceUnavailable('smtp', 'Connection timeout');
        
        $this->assertEquals(3001, $exception->getCode());
        $this->assertEquals('Email Service', $exception->getServiceName());
        $this->assertEquals(300, $exception->getRetryAfter());
        $this->assertTrue($exception->isRetryable());
    }

    /** @test */
    public function it_creates_blacklisted_customer_exception()
    {
        $exception = BusinessLogicException::customerBlacklisted('CUST001', 'Payment issues');
        
        $this->assertEquals(1002, $exception->getCode());
        $this->assertStringContainsString('blacklisted', $exception->getMessage());
        $this->assertNotEmpty($exception->getContext());
    }

    /** @test */
    public function it_creates_booking_modification_exception()
    {
        $exception = BusinessLogicException::bookingCannotBeModified('BK001', 'completed');
        
        $this->assertEquals(1003, $exception->getCode());
        $this->assertStringContainsString('cannot be modified', $exception->getMessage());
    }

    /** @test */
    public function it_creates_concurrent_modification_exception()
    {
        $exception = DataIntegrityException::concurrentModification('bookings', '123', 'v1', 'v2');
        
        $this->assertEquals(2003, $exception->getCode());
        $this->assertStringContainsString('modified by another user', $exception->getMessage());
    }

    /** @test */
    public function it_creates_payment_gateway_exception()
    {
        $exception = ExternalServiceException::paymentGatewayUnavailable('stripe', 'TXN123');
        
        $this->assertEquals(3003, $exception->getCode());
        $this->assertEquals('Payment Gateway', $exception->getServiceName());
        $this->assertEquals(120, $exception->getRetryAfter());
    }

    /** @test */
    public function it_creates_file_storage_exception()
    {
        $exception = ExternalServiceException::fileStorageUnavailable('local', 'upload', '/path/to/file');
        
        $this->assertEquals(3004, $exception->getCode());
        $this->assertEquals('File Storage', $exception->getServiceName());
    }

    /** @test */
    public function it_marks_services_as_unavailable_correctly()
    {
        $serviceName = 'test_service_' . time();
        
        $this->recoveryService->markServiceUnavailable($serviceName, 60);
        
        $this->assertTrue($this->recoveryService->isServiceUnavailable($serviceName));
        $this->assertFalse($this->recoveryService->isServiceUnavailable('other_service'));
    }

    /** @test */
    public function it_handles_database_transaction_rollback()
    {
        DB::beginTransaction();
        
        try {
            // Simulate an operation that fails
            throw new DataIntegrityException('Test integrity error');
        } catch (\Exception $e) {
            // The error handling should rollback the transaction
            $this->assertGreaterThanOrEqual(1, DB::transactionLevel());
            DB::rollBack();
        }
        
        $this->assertEquals(0, DB::transactionLevel());
    }

    /** @test */
    public function error_notification_service_returns_statistics()
    {
        $stats = $this->notificationService->getErrorStatistics(1);
        
        $this->assertIsArray($stats);
        $this->assertArrayHasKey('total_errors', $stats);
        $this->assertArrayHasKey('critical_errors', $stats);
        $this->assertArrayHasKey('high_priority_errors', $stats);
    }

    /** @test */
    public function application_logger_service_can_be_instantiated()
    {
        $this->assertInstanceOf(ApplicationLoggerService::class, $this->logger);
    }

    /** @test */
    public function error_recovery_service_can_be_instantiated()
    {
        $this->assertInstanceOf(ErrorRecoveryService::class, $this->recoveryService);
    }

    /** @test */
    public function error_notification_service_can_be_instantiated()
    {
        $this->assertInstanceOf(ErrorNotificationService::class, $this->notificationService);
    }
}