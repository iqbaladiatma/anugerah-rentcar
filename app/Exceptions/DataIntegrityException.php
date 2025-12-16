<?php

namespace App\Exceptions;

use Exception;

/**
 * Exception thrown when data integrity constraints are violated.
 * These indicate serious data consistency issues that require immediate attention.
 */
class DataIntegrityException extends Exception
{
    protected array $affectedTables = [];
    protected array $recoverySuggestions = [];
    protected ?string $transactionId = null;

    public function __construct(
        string $message = '',
        int $code = 0,
        ?Exception $previous = null,
        array $affectedTables = [],
        array $recoverySuggestions = [],
        ?string $transactionId = null
    ) {
        parent::__construct($message, $code, $previous);
        $this->affectedTables = $affectedTables;
        $this->recoverySuggestions = $recoverySuggestions;
        $this->transactionId = $transactionId;
    }

    /**
     * Get tables affected by this data integrity issue.
     */
    public function getAffectedTables(): array
    {
        return $this->affectedTables;
    }

    /**
     * Get suggestions for recovering from this error.
     */
    public function getRecoverySuggestions(): array
    {
        return $this->recoverySuggestions;
    }

    /**
     * Get the transaction ID if available.
     */
    public function getTransactionId(): ?string
    {
        return $this->transactionId;
    }

    /**
     * Create exception for foreign key constraint violations.
     */
    public static function foreignKeyViolation(
        string $table,
        string $column,
        mixed $value
    ): self {
        return new self(
            "Foreign key constraint violation detected.",
            2001,
            null,
            [$table],
            [
                'Verify referenced record exists',
                'Check data synchronization',
                'Contact system administrator'
            ]
        );
    }

    /**
     * Create exception for unique constraint violations.
     */
    public static function uniqueConstraintViolation(
        string $table,
        string $column,
        mixed $value
    ): self {
        return new self(
            "Duplicate value detected for unique field.",
            2002,
            null,
            [$table],
            [
                'Use a different value',
                'Check if record already exists',
                'Update existing record instead'
            ]
        );
    }

    /**
     * Create exception for concurrent modification conflicts.
     */
    public static function concurrentModification(
        string $table,
        string $recordId,
        string $expectedVersion,
        string $actualVersion
    ): self {
        return new self(
            "Record was modified by another user. Please refresh and try again.",
            2003,
            null,
            [$table],
            [
                'Refresh the page and retry',
                'Merge changes manually',
                'Contact other users to coordinate'
            ]
        );
    }

    /**
     * Create exception for orphaned record detection.
     */
    public static function orphanedRecord(
        string $table,
        string $recordId,
        string $parentTable
    ): self {
        return new self(
            "Orphaned record detected - parent record no longer exists.",
            2004,
            null,
            [$table, $parentTable],
            [
                'Restore parent record',
                'Remove orphaned record',
                'Update relationships'
            ]
        );
    }

    /**
     * Create exception for data corruption detection.
     */
    public static function dataCorruption(
        string $table,
        string $recordId,
        array $corruptedFields
    ): self {
        return new self(
            "Data corruption detected in record.",
            2005,
            null,
            [$table],
            [
                'Restore from backup',
                'Manually correct corrupted data',
                'Contact system administrator immediately'
            ]
        );
    }

    /**
     * Create exception for transaction rollback failures.
     */
    public static function transactionRollbackFailed(
        string $transactionId,
        array $affectedTables
    ): self {
        return new self(
            "Critical: Transaction rollback failed. Data may be in inconsistent state.",
            2006,
            null,
            $affectedTables,
            [
                'Stop all operations immediately',
                'Contact system administrator',
                'Restore from backup if necessary'
            ],
            $transactionId
        );
    }
}