<?php

namespace Tonysm\StimulusLaravel\Commands\Concerns;

use Illuminate\Support\Facades\File;

/**
 * @mixin \Tonysm\StimulusLaravel\Commands\InstallCommand
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
        File::copy(__DIR__.'/../../../stubs/resources/js/controllers/hello_controller.js', resource_path('js/controllers/hello_controller.js'));
        File::copy(__DIR__.'/../../../stubs/resources/js/controllers/index-importmap.js', resource_path('js/controllers/index.js'));

        $libsIndexFile = resource_path('js/libs/index.js');
        $libsIndexSourceFile = __DIR__.'/../../../stubs/resources/js/libs/index-importmap.js';

        if (File::exists($libsIndexFile)) {
            $importLine = trim(File::get($libsIndexSourceFile));

            if (! str_contains(File::get($libsIndexFile), $importLine)) {
                File::append($libsIndexFile, $importLine.PHP_EOL);
            }
        } else {
            File::copy($libsIndexSourceFile, $libsIndexFile);
        }
    }

    protected function registerImportmapPins()
    {
        $this->callSilently('importmap:pin', [
            'packages' => ['@hotwired/stimulus'],
        ]);

        // Publishes the `@hotwired/stimulus-loading` and the std controllers to public/
        $this->callSilently('vendor:publish', [
            '--tag' => 'stimulus-laravel-assets',
        ]);

        File::append($this->importmapsFile(), <<<'IMPORTMAP'
        Importmap::pin("@hotwired/stimulus-loading", to: "vendor/stimulus-laravel/stimulus-loading.js", preload: true);
        Importmap::pinAllFrom("public/vendor/stimulus-laravel/controllers", to: "vendor/stimulus-laravel/controllers", under: "std", preload: true);

        IMPORTMAP);
    }
}
