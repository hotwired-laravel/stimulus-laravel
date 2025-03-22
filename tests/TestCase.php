<?php

namespace HotwiredLaravel\StimulusLaravel\Tests;

use HotwiredLaravel\StimulusLaravel\StimulusLaravelServiceProvider;
use Illuminate\Database\Eloquent\Factories\Factory;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName): string => 'Tonysm\\StimulusLaravel\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    public function getEnvironmentSetUp($app): void
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_stimulus-laravel_table.php.stub';
        $migration->up();
        */
    }

    protected function getPackageProviders($app)
    {
        return [
            StimulusLaravelServiceProvider::class,
        ];
    }
}
