<?php

namespace Tonysm\StimulusLaravel;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class StimulusGenerator
{
    public function __construct(private ?string $targetFolder = null)
    {
        $this->targetFolder ??= rtrim(resource_path('js/controllers'), '/');
    }

    public function create(string $name): array
    {
        $controllerName = $this->controllerName($name);
        $targetFile = $this->targetFolder . '/' . $controllerName . '_controller.js';

        File::ensureDirectoryExists(dirname($targetFile));

        File::put(
            $targetFile,
            str_replace('[attribute]', $attributeName = $this->attributeName($name), File::get(__DIR__ . '/../stubs/controller.stub')),
        );

        return [
            'file' => $targetFile,
            'controller_name' => $controllerName,
            'attribute_name' => $attributeName,
        ];
    }

    private function controllerName(string $name): string
    {
        return Str::of($name)->replace('_controller', '')->snake('_');
    }

    private function attributeName(string $name): string
    {
        return Str::of($this->controllerName($name))->replace('/', '--')->snake('_', '-');
    }
}
