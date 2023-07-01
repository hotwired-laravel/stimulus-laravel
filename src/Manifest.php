<?php

namespace HotwiredLaravel\StimulusLaravel;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use SplFileInfo;

class Manifest
{
    public function generateFrom(string $controllersPath): Collection
    {
        return collect(File::allFiles($controllersPath))
            ->filter(fn (SplFileInfo $file) => str_contains($file->getFilename(), '_controller'))
            ->values()
            ->map(function (SplFileInfo $file) use ($controllersPath) {
                $controllerPath = $this->relativePathFrom($file->getRealPath(), $controllersPath);
                $modulePath = Str::before($controllerPath, '.');
                $controllerClassName = Str::of($modulePath)
                    ->explode(DIRECTORY_SEPARATOR)
                    ->map(fn ($piece) => Str::studly($piece))
                    ->join('__');
                $tagName = Str::of($modulePath)->before('_controller')->replace('_', '-')->replace(DIRECTORY_SEPARATOR, '--')->toString();

                $join = function ($paths) {
                    return implode(DIRECTORY_SEPARATOR, $paths);
                };

                return <<<JS

                import {$controllerClassName} from '{$join(['.', $modulePath])}'
                application.register('{$tagName}', {$controllerClassName})
                JS;
            });
    }

    private function relativePathFrom(string $controllerPath, string $basePath)
    {
        return trim(str_replace($basePath, '', $controllerPath), DIRECTORY_SEPARATOR);
    }
}
