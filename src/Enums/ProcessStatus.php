<?php

declare(strict_types=1);

namespace Abdullah\IsyerimPos\Enums;

/**
 * Transaction Process Status
 *
 * Represents the lifecycle state of a payment transaction.
 */
enum ProcessStatus: int
{
    case UNDEFINED = 0;
    case PENDING = 1;
    case VERIFIED = 2;
    case SUCCESSFUL = 4;
    case FAILED = 5;
    case CANCELLED = 6;
    case CANCELLATION_IN_PROGRESS = 7;
    case REFUND_IN_PROGRESS = 8;
    case CHARGEBACK_IN_PROGRESS = 9;
    case RISKY = 10;

    /**
     * Get the human-readable name of the process status.
     */
    public function label(): string
    {
        return match ($this) {
            self::UNDEFINED => 'Undefined',
            self::PENDING => 'Pending',
            self::VERIFIED => 'Verified',
            self::SUCCESSFUL => 'Successful',
            self::FAILED => 'Failed',
            self::CANCELLED => 'Cancelled',
            self::CANCELLATION_IN_PROGRESS => 'Cancellation In Progress',
            self::REFUND_IN_PROGRESS => 'Refund In Progress',
            self::CHARGEBACK_IN_PROGRESS => 'Chargeback In Progress',
            self::RISKY => 'Risky',
        };
    }

    /**
     * Check if the status represents a final state.
     */
    public function isFinal(): bool
    {
        return match ($this) {
            self::SUCCESSFUL, self::FAILED, self::CANCELLED => true,
            default => false,
        };
    }

    /**
     * Check if the status represents a pending/in-progress state.
     */
    public function isPending(): bool
    {
        return match ($this) {
            self::PENDING,
            self::VERIFIED,
            self::CANCELLATION_IN_PROGRESS,
            self::REFUND_IN_PROGRESS,
            self::CHARGEBACK_IN_PROGRESS => true,
            default => false,
        };
    }

    /**
     * Check if the status represents a successful state.
     */
    public function isSuccessful(): bool
    {
        return $this === self::SUCCESSFUL;
    }

    /**
     * Check if the status represents a failed state.
     */
    public function isFailed(): bool
    {
        return $this === self::FAILED;
    }

    /**
     * Create enum from integer value, returns null if invalid.
     */
    public static function tryFromValue(?int $value): ?self
    {
        if ($value === null) {
            return null;
        }

        return self::tryFrom($value);
    }
}
