<?php

namespace HotwiredLaravel\StimulusLaravel\Commands\Concerns;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

/**
 * @mixin \HotwiredLaravel\StimulusLaravel\Commands\InstallCommand
 */
trait InstallsForImportmap
{
    protected function installsForImportmaps()
    {
        $this->publishJsFilesForImportmaps();
        $this->registerImportmapPins();
    }

    protected function publishJsFilesForImportmaps()
    {
        File::ensureDirectoryExists(resource_path('js/controllers'));
        File::ensureDirectoryExists(resource_path('js/libs'));

        File::copy(__DIR__.'/../../../stubs/resources/js/libs/stimulus.js', resource_path('js/libs/stimulus.js'));
        File::copy(__DIR__.'/../../../stubs/resources/js/controllers/index-importmap.js', resource_path('js/controllers/index.js'));

        $libsIndexFile = resource_path('js/libs/index.js');
        $libsIndexSourceFile = __DIR__.'/../../../stubs/resources/js/libs/index-importmap.js';

        if (File::exists($libsIndexFile)) {
            $importLine = trim(File::get($libsIndexSourceFile));

            if (! str_contains(File::get($libsIndexFile), $importLine)) {
                File::append($libsIndexFile, PHP_EOL.$importLine.PHP_EOL);
            }
        } else {
            File::copy($libsIndexSourceFile, $libsIndexFile);
        }
    }

    protected function registerImportmapPins()
    {
        $dependencies = collect($this->jsPackages())
            ->map(fn ($version, $package): string => "{$package}@{$version}")
            ->values()
            ->all();

        Process::forever()->run(array_merge([
            $this->phpBinary(),
            'artisan',
            'importmap:pin',
        ], $dependencies), function ($_type, $output): void {
            $this->output->write($output);
        });

        // Publishes the `@hotwired/stimulus-loading` package to public/vendor
        Process::forever()->run([
            $this->phpBinary(),
            'artisan',
            'vendor:publish',
            '--tag',
            'stimulus-laravel-assets',
        ], function ($_type, $output): void {
            $this->output->write($output);
        });

        File::append($this->importmapsFile(), <<<'IMPORTMAP'
        Importmap::pin("@hotwired/stimulus-loading", to: "vendor/stimulus-laravel/stimulus-loading.js", preload: true);
        IMPORTMAP);
    }
}
