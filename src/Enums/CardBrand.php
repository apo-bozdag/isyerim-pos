<?php

declare(strict_types=1);

namespace Abdullah\IsyerimPos\Enums;

/**
 * Card Brand (Turkish Card Programs)
 *
 * Represents Turkish bank card programs and loyalty brands.
 */
enum CardBrand: int
{
    case UNDEFINED = 0;
    case ADVANTAGE = 1;
    case AXESS = 2;
    case BONUS = 3;
    case CARD_FINANS = 4;
    case COMBO = 5;
    case MAXIMUM = 6;
    case PARAF = 7;
    case WORLD = 8;
    case BANKKART = 9;
    case SAGLAMKART = 10;
    case PARAM = 11;
    case WINGS = 12;
    case FLEXI = 13;
    case SENINKART = 14;
    case CHIP = 15;
    case TROY = 16;
    case EXCELLENCE = 17;
    case OTHER = 18;

    /**
     * Get the human-readable name of the card brand.
     */
    public function label(): string
    {
        return match ($this) {
            self::UNDEFINED => 'Undefined',
            self::ADVANTAGE => 'Advantage',
            self::AXESS => 'Axess',
            self::BONUS => 'Bonus',
            self::CARD_FINANS => 'CardFinans',
            self::COMBO => 'Combo',
            self::MAXIMUM => 'Maximum',
            self::PARAF => 'Paraf',
            self::WORLD => 'World',
            self::BANKKART => 'Bankkart',
            self::SAGLAMKART => 'Sağlamkart',
            self::PARAM => 'Param',
            self::WINGS => 'Wings',
            self::FLEXI => 'Flexi',
            self::SENINKART => 'Seninkart',
            self::CHIP => 'Chip',
            self::TROY => 'Troy',
            self::EXCELLENCE => 'Excellence',
            self::OTHER => 'Other',
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
