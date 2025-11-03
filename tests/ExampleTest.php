<?php

use Abdullah\IsyerimPos\Facades\IsyerimPos;

it('can instantiate IsyerimPos', function () {
    $pos = new \Abdullah\IsyerimPos\IsyerimPos;

    expect($pos)->toBeInstanceOf(\Abdullah\IsyerimPos\IsyerimPos::class);
});

it('can access virtualPos service', function () {
    $pos = new \Abdullah\IsyerimPos\IsyerimPos;

    expect($pos->virtualPos())->toBeInstanceOf(\Abdullah\IsyerimPos\Services\VirtualPosService::class);
});

it('can access physicalPos service', function () {
    $pos = new \Abdullah\IsyerimPos\IsyerimPos;

    expect($pos->physicalPos())->toBeInstanceOf(\Abdullah\IsyerimPos\Services\PhysicalPosService::class);
});

it('can access marketplace service', function () {
    $pos = new \Abdullah\IsyerimPos\IsyerimPos;

    expect($pos->marketplace())->toBeInstanceOf(\Abdullah\IsyerimPos\Services\MarketplaceService::class);
});

it('can access wallet service', function () {
    $pos = new \Abdullah\IsyerimPos\IsyerimPos;

    expect($pos->wallet())->toBeInstanceOf(\Abdullah\IsyerimPos\Services\WalletService::class);
});

it('can use facade', function () {
    expect(IsyerimPos::virtualPos())->toBeInstanceOf(\Abdullah\IsyerimPos\Services\VirtualPosService::class);
    expect(IsyerimPos::physicalPos())->toBeInstanceOf(\Abdullah\IsyerimPos\Services\PhysicalPosService::class);
    expect(IsyerimPos::marketplace())->toBeInstanceOf(\Abdullah\IsyerimPos\Services\MarketplaceService::class);
    expect(IsyerimPos::wallet())->toBeInstanceOf(\Abdullah\IsyerimPos\Services\WalletService::class);
});
