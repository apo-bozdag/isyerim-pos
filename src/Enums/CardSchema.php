<?php

declare(strict_types=1);

namespace Abdullah\IsyerimPos\Enums;

/**
 * Card Network Schema
 *
 * Represents the card network/scheme (Visa, MasterCard, etc.).
 */
enum CardSchema: int
{
    case UNDEFINED = 0;
    case VISA = 1;
    case MASTERCARD = 2;
    case AMEX = 3;
    case DINERS_CLUB = 4;
    case JCB = 5;
    case TROY = 6;
    case UNION_PAY = 7;
    case PROPRIETARY_DOMESTIC = 8;

    /**
     * Get the human-readable name of the card schema.
     */
    public function label(): string
    {
        return match ($this) {
            self::UNDEFINED => 'Undefined',
            self::VISA => 'Visa',
            self::MASTERCARD => 'MasterCard',
            self::AMEX => 'American Express',
            self::DINERS_CLUB => 'Diners Club',
            self::JCB => 'JCB',
            self::TROY => 'Troy',
            self::UNION_PAY => 'UnionPay',
            self::PROPRIETARY_DOMESTIC => 'Proprietary Domestic',
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
