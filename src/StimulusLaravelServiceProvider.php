<?php

namespace HotwiredLaravel\StimulusLaravel;

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
                Commands\CoreMakeCommand::class,
                Commands\PublishCommand::class,
                Commands\ManifestCommand::class,
            ]);
    }

    public function packageBooted(): void
    {
        $this->bindDirectivesIfEnabled();
    }

    private function bindDirectivesIfEnabled(): void
    {
        if (! Features::enabled(Features::directives())) {
            return;
        }

        Blade::directive('controller', fn ($expression): string => "<?php echo \HotwiredLaravel\StimulusLaravel\Facades\StimulusLaravel::controller({$expression}); ?>");

        Blade::directive('target', fn ($expression): string => "<?php echo \HotwiredLaravel\StimulusLaravel\Facades\StimulusLaravel::target({$expression}); ?>");
    }
}
