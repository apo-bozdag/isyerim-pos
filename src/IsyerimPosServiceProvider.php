<?php

namespace Abdullah\IsyerimPos;

use Abdullah\IsyerimPos\Contracts\IsyerimPosInterface;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class IsyerimPosServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('isyerim-pos')
            ->hasConfigFile();
    }

    public function packageRegistered(): void
    {
        $this->app->singleton(IsyerimPosInterface::class, function () {
            return new IsyerimPos;
        });

        $this->app->alias(IsyerimPosInterface::class, IsyerimPos::class);
    }
}
