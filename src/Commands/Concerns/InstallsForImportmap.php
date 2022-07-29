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

        File::copy(__DIR__.'/../../../resources/js/libs/stimulus.js', resource_path('js/libs/stimulus.js'));
        File::copy(__DIR__.'/../../../resources/js/libs/stimulus-loading-importmap.js', resource_path('js/libs/stimulus-loading.js'));
        File::copy(__DIR__.'/../../../resources/js/controllers/hello_controller.js', resource_path('js/controllers/hello_controller.js'));
        File::copy(__DIR__.'/../../../resources/js/controllers/index-importmap.js', resource_path('js/controllers/index.js'));

        $libsIndexFile = resource_path('js/libs/index.js');
        $libsIndexSourceFile = __DIR__.'/../../../resources/js/libs/index-importmap.js';

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
    }
}
