<?php

namespace Abdullah\IsyerimPos;

use Abdullah\IsyerimPos\Client\IsyerimPosClient;
use Abdullah\IsyerimPos\Contracts\IsyerimPosInterface;
use Abdullah\IsyerimPos\Services\MarketplaceService;
use Abdullah\IsyerimPos\Services\PhysicalPosService;
use Abdullah\IsyerimPos\Services\VirtualPosService;
use Abdullah\IsyerimPos\Services\WalletService;

class IsyerimPos implements IsyerimPosInterface
{
    protected IsyerimPosClient $client;

    protected VirtualPosService $virtualPosService;

    protected PhysicalPosService $physicalPosService;

    protected MarketplaceService $marketplaceService;

    protected WalletService $walletService;

    public function __construct()
    {
        $this->client = new IsyerimPosClient;
    }

    /**
     * Get Virtual POS service instance.
     */
    public function virtualPos(): VirtualPosService
    {
        return $this->virtualPosService ??= new VirtualPosService($this->client);
    }

    /**
     * Get Physical POS service instance.
     */
    public function physicalPos(): PhysicalPosService
    {
        return $this->physicalPosService ??= new PhysicalPosService($this->client);
    }

    /**
     * Get Marketplace service instance.
     */
    public function marketplace(): MarketplaceService
    {
        return $this->marketplaceService ??= new MarketplaceService($this->client);
    }

    /**
     * Get Wallet service instance.
     */
    public function wallet(): WalletService
    {
        return $this->walletService ??= new WalletService($this->client);
    }
}
