<?php

declare(strict_types=1);

namespace Abdullah\IsyerimPos\Enums;

/**
 * Card Type Classification
 *
 * Represents the type of payment card.
 */
enum CardType: int
{
    case UNDEFINED = 0;
    case CREDIT_CARD = 1;
    case DEBIT_CARD = 2;
    case ACQUIRING = 3;
    case PREPAID = 4;

    /**
     * Get the human-readable name of the card type.
     */
    public function label(): string
    {
        return match ($this) {
            self::UNDEFINED => 'Undefined',
            self::CREDIT_CARD => 'Credit Card',
            self::DEBIT_CARD => 'Debit Card',
            self::ACQUIRING => 'Acquiring',
            self::PREPAID => 'Prepaid',
        };
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
