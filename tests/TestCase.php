<?php

namespace Abdullah\IsyerimPos\Tests;

use Abdullah\IsyerimPos\IsyerimPosServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Abdullah\\IsyerimPos\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            IsyerimPosServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        // Set test credentials for IsyerimPOS
        config()->set('isyerim-pos.merchant_id', 'test-merchant-id');
        config()->set('isyerim-pos.user_id', 'test-user-id');
        config()->set('isyerim-pos.api_key', 'test-api-key');
        config()->set('isyerim-pos.base_url', 'https://apitest.isyerimpos.com/v1/');

        /*
         foreach (\Illuminate\Support\Facades\File::allFiles(__DIR__ . '/../database/migrations') as $migration) {
            (include $migration->getRealPath())->up();
         }
         */
    }
}
