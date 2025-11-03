<?php

namespace Abdullah\IsyerimPos\Contracts;

use Abdullah\IsyerimPos\Services\MarketplaceService;
use Abdullah\IsyerimPos\Services\PhysicalPosService;
use Abdullah\IsyerimPos\Services\VirtualPosService;
use Abdullah\IsyerimPos\Services\WalletService;

interface IsyerimPosInterface
{
    /**
     * Get Virtual POS service instance.
     */
    public function virtualPos(): VirtualPosService;

    /**
     * Get Physical POS service instance.
     */
    public function physicalPos(): PhysicalPosService;

    /**
     * Get Marketplace service instance.
     */
    public function marketplace(): MarketplaceService;

    /**
     * Get Wallet service instance.
     */
    public function wallet(): WalletService;
}
