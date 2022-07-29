<?php

namespace Tonysm\StimulusLaravel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Tonysm\StimulusLaravel\Commands\StimulusLaravelCommand;

class StimulusLaravelServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('stimulus-laravel')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_stimulus-laravel_table')
            ->hasCommand(StimulusLaravelCommand::class);
    }
}
