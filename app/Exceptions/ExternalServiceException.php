<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception thrown when external services fail or are unavailable.
 * These indicate temporary issues that may resolve with retry.
 */
class ExternalServiceException extends Exception
{
    protected string $serviceName;
    protected ?int $retryAfter = null;
    protected array $serviceContext = [];
    protected bool $isRetryable = true;

    public function __construct(
        string $serviceName,
        string $message = '',
        int $code = 0,
        ?Exception $previous = null,
        ?int $retryAfter = null,
        array $serviceContext = [],
        bool $isRetryable = true
    ) {
        parent::__construct($message, $code, $previous);
        $this->serviceName = $serviceName;
        $this->retryAfter = $retryAfter;
        $this->serviceContext = $serviceContext;
        $this->isRetryable = $isRetryable;
    }

    /**
     * Get the name of the failing service.
     */
    public function getServiceName(): string
    {
        return $this->serviceName;
    }

    /**
     * Get the suggested retry delay in seconds.
     */
    public function getRetryAfter(): ?int
    {
        return $this->retryAfter;
    }

    /**
     * Get additional context about the service failure.
     */
    public function getServiceContext(): array
    {
        return $this->serviceContext;
    }

    /**
     * Check if this failure is retryable.
     */
    public function isRetryable(): bool
    {
        return $this->isRetryable;
    }

    /**
     * Create exception for email service failures.
     */
    public static function emailServiceUnavailable(
        string $provider,
        ?string $errorDetails = null
    ): self {
        return new self(
            'Email Service',
            "Email service is currently unavailable.",
            3001,
            null,
            300, // Retry after 5 minutes
            [
                'provider' => $provider,
                'error_details' => $errorDetails,
            ]
        );
    }

    /**
     * Create exception for SMS service failures.
     */
    public static function smsServiceUnavailable(
        string $provider,
        ?string $errorDetails = null
    ): self {
        return new self(
            'SMS Service',
            "SMS service is currently unavailable.",
            3002,
            null,
            600, // Retry after 10 minutes
            [
                'provider' => $provider,
                'error_details' => $errorDetails,
            ]
        );
    }

    /**
     * Create exception for payment gateway failures.
     */
    public static function paymentGatewayUnavailable(
        string $gateway,
        ?string $transactionId = null
    ): self {
        return new self(
            'Payment Gateway',
            "Payment processing is temporarily unavailable.",
            3003,
            null,
            120, // Retry after 2 minutes
            [
                'gateway' => $gateway,
                'transaction_id' => $transactionId,
            ]
        );
    }

    /**
     * Create exception for file storage service failures.
     */
    public static function fileStorageUnavailable(
        string $disk,
        string $operation,
        ?string $filePath = null
    ): self {
        return new self(
            'File Storage',
            "File storage service is temporarily unavailable.",
            3004,
            null,
            60, // Retry after 1 minute
            [
                'disk' => $disk,
                'operation' => $operation,
                'file_path' => $filePath,
            ]
        );
    }

    /**
     * Create exception for external API failures.
     */
    public static function apiServiceUnavailable(
        string $apiName,
        string $endpoint,
        int $httpStatus,
        ?string $responseBody = null
    ): self {
        $isRetryable = in_array($httpStatus, [429, 500, 502, 503, 504]);
        $retryAfter = $httpStatus === 429 ? 3600 : 300; // 1 hour for rate limit, 5 min for others

        return new self(
            $apiName,
            "External API service is unavailable.",
            3005,
            null,
            $retryAfter,
            [
                'endpoint' => $endpoint,
                'http_status' => $httpStatus,
                'response_body' => $responseBody,
            ],
            $isRetryable
        );
    }

    /**
     * Create exception for database connection failures.
     */
    public static function databaseUnavailable(
        string $connection,
        ?string $errorDetails = null
    ): self {
        return new self(
            'Database',
            "Database connection is unavailable.",
            3006,
            null,
            30, // Retry after 30 seconds
            [
                'connection' => $connection,
                'error_details' => $errorDetails,
            ],
            false // Database issues are usually not retryable without intervention
        );
    }

    /**
     * Create exception for virus scanning service failures.
     */
    public static function virusScannerUnavailable(
        string $scanner,
        ?string $filePath = null
    ): self {
        return new self(
            'Virus Scanner',
            "Virus scanning service is temporarily unavailable.",
            3007,
            null,
            180, // Retry after 3 minutes
            [
                'scanner' => $scanner,
                'file_path' => $filePath,
            ]
        );
    }
}