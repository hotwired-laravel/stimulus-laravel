<?php

namespace Tonysm\StimulusLaravel;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

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
            ->hasAssets()
            ->hasCommands([
                Commands\InstallCommand::class,
                Commands\MakeCommand::class,
            ]);
    }
}
