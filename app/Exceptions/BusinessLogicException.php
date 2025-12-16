<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception thrown when business rules are violated.
 * These are typically user-correctable errors.
 */
class BusinessLogicException extends Exception
{
    protected array $context = [];
    protected array $recoverySuggestions = [];

    public function __construct(
        string $message = '',
        int $code = 0,
        ?Exception $previous = null,
        array $context = [],
        array $recoverySuggestions = []
    ) {
        parent::__construct($message, $code, $previous);
        $this->context = $context;
        $this->recoverySuggestions = $recoverySuggestions;
    }

    /**
     * Get additional context information about the exception.
     */
    public function getContext(): array
    {
        return $this->context;
    }

    /**
     * Get suggestions for recovering from this error.
     */
    public function getRecoverySuggestions(): array
    {
        return $this->recoverySuggestions;
    }

    /**
     * Create exception for vehicle availability conflicts.
     */
    public static function vehicleNotAvailable(
        string $vehicleId,
        string $startDate,
        string $endDate
    ): self {
        return new self(
            "Vehicle is not available for the selected dates.",
            1001,
            null,
            [
                'vehicle_id' => $vehicleId,
                'requested_start' => $startDate,
                'requested_end' => $endDate,
            ],
            [
                'Select different dates',
                'Choose another vehicle',
                'Contact staff for assistance'
            ]
        );
    }

    /**
     * Create exception for blacklisted customer attempts.
     */
    public static function customerBlacklisted(string $customerId, string $reason): self
    {
        return new self(
            "Customer is blacklisted and cannot make new bookings.",
            1002,
            null,
            [
                'customer_id' => $customerId,
                'blacklist_reason' => $reason,
            ],
            [
                'Contact administration to resolve blacklist status',
                'Provide additional documentation if required'
            ]
        );
    }

    /**
     * Create exception for invalid booking modifications.
     */
    public static function bookingCannotBeModified(string $bookingId, string $status): self
    {
        return new self(
            "Booking cannot be modified in its current status.",
            1003,
            null,
            [
                'booking_id' => $bookingId,
                'current_status' => $status,
            ],
            [
                'Contact staff to discuss modification options',
                'Cancel and create a new booking if permitted'
            ]
        );
    }

    /**
     * Create exception for insufficient member privileges.
     */
    public static function memberPrivilegeRequired(string $action): self
    {
        return new self(
            "Member status is required for this action.",
            1004,
            null,
            [
                'required_action' => $action,
            ],
            [
                'Upgrade to member status',
                'Contact staff about membership benefits'
            ]
        );
    }

    /**
     * Create exception for invalid pricing calculations.
     */
    public static function invalidPricingParameters(array $parameters): self
    {
        return new self(
            "Invalid parameters provided for pricing calculation.",
            1005,
            null,
            [
                'provided_parameters' => $parameters,
            ],
            [
                'Verify all required fields are filled',
                'Check date ranges are valid',
                'Ensure vehicle selection is correct'
            ]
        );
    }
}