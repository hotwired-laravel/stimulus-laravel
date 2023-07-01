<?php

namespace HotwiredLaravel\StimulusLaravel\Commands\Concerns;

use Illuminate\Support\Facades\File;

/**
 * @mixin \HotwiredLaravel\StimulusLaravel\Commands\InstallCommand
 */
trait InstallsForNode
{
    protected function installsForNode()
    {
        $this->publishJsFilesForNode();
        $this->updateNpmPackagesForNode();
    }

    protected function publishJsFilesForNode()
    {
        $this->components->task('publishing JS files', function () {
            File::ensureDirectoryExists(resource_path('js/controllers'));
            File::ensureDirectoryExists(resource_path('js/libs'));

            File::copy(__DIR__.'/../../../stubs/resources/js/libs/stimulus.js', resource_path('js/libs/stimulus.js'));
            File::copy(__DIR__.'/../../../stubs/resources/js/controllers/hello_controller.js', resource_path('js/controllers/hello_controller.js'));
            File::copy(__DIR__.'/../../../stubs/resources/js/controllers/index-node.js', resource_path('js/controllers/index.js'));

            $libsIndexFile = resource_path('js/libs/index.js');
            $libsIndexSourceFile = __DIR__.'/../../../stubs/resources/js/libs/index-node.js';

            if (File::exists($libsIndexFile)) {
                $importLine = trim(File::get($libsIndexSourceFile));

                if (! str_contains(File::get($libsIndexFile), $importLine)) {
                    File::append($libsIndexFile, $importLine.PHP_EOL);
                }
            } else {
                File::copy($libsIndexSourceFile, $libsIndexFile);
            }

            if (! str_contains(File::get(resource_path('js/app.js')), "import './libs';")) {
                File::append(resource_path('js/app.js'), <<<'JS'
                import './libs';

                JS);
            }

            return true;
        });
    }

    protected function updateNpmPackagesForNode()
    {
        $this->components->task('registering NPM dependency', function () {
            $this->updateNodePackages(function ($packages) {
                return [
                    '@hotwired/stimulus' => '^3.1.0',
                ] + $packages;
            });

            $this->afterMessages[] = '<fg=white>Run: `<fg=yellow>npm install && npm run dev</>`</>';

            return true;
        });
    }

    /**
     * @param  callable  $callback
     * @param  bool  $dev
     * @return void
     */
    protected static function updateNodePackages(callable $callback, $dev = true)
    {
        if (! File::exists(base_path('package.json'))) {
            return;
        }

        $configurationKey = $dev ? 'devDependencies' : 'dependencies';

        $packages = json_decode(File::get(base_path('package.json')), true);

        $packages[$configurationKey] = $callback(
            array_key_exists($configurationKey, $packages) ? $packages[$configurationKey] : [],
            $configurationKey
        );

        ksort($packages[$configurationKey]);

        File::put(
            base_path('package.json'),
            json_encode($packages, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT).PHP_EOL
        );
    }
}
