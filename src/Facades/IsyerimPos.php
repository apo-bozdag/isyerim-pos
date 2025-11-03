<?php

namespace Abdullah\IsyerimPos\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \Abdullah\IsyerimPos\Services\VirtualPosService virtualPos()
 * @method static \Abdullah\IsyerimPos\Services\PhysicalPosService physicalPos()
 * @method static \Abdullah\IsyerimPos\Services\MarketplaceService marketplace()
 * @method static \Abdullah\IsyerimPos\Services\WalletService wallet()
 *
 * @see \Abdullah\IsyerimPos\IsyerimPos
 */
class IsyerimPos extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Abdullah\IsyerimPos\IsyerimPos::class;
    }
}
