<?php

namespace Tonysm\StimulusLaravel;

use Illuminate\Support\Facades\Blade;
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
            ->hasConfigFile()
            ->hasCommands([
                Commands\InstallCommand::class,
                Commands\MakeCommand::class,
            ]);
    }

    public function packageBooted()
    {
        $this->bindDirectivesIfEnabled();
    }

    private function bindDirectivesIfEnabled()
    {
        if (! Features::enabled(Features::directives())) {
            return;
        }

        Blade::directive('controller', function ($expression) {
            return "<?php echo \Tonysm\StimulusLaravel\Facades\StimulusLaravel::controller($expression); ?>";
        });

        Blade::directive('target', function ($expression) {
            return "<?php echo \Tonysm\StimulusLaravel\Facades\StimulusLaravel::target($expression); ?>";
        });
    }
}
