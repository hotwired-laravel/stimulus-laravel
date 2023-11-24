<?php

namespace HotwiredLaravel\StimulusLaravel;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class StimulusGenerator
{
    public function __construct(private ?string $targetFolder = null)
    {
        $this->targetFolder ??= rtrim(resource_path('js/controllers'), '/');
    }

    public function create(string $name, string $stub = null, callable $replacementsCallback = null): array
    {
        $replacementsCallback ??= fn ($replacements) => $replacements;
        $controllerName = $this->controllerName($name);
        $targetFile = $this->targetFolder.'/'.$controllerName.'_controller.js';

        File::ensureDirectoryExists(dirname($targetFile));

        $replacements = $replacementsCallback([
            '[attribute]' => $attributeName = $this->attributeName($name),
        ]);

        File::put(
            $targetFile,
            str_replace(array_keys($replacements), array_values($replacements), File::get($stub ?: __DIR__.'/../stubs/controller.stub')),
        );

        return [
            'file' => $targetFile,
            'controller_name' => $controllerName,
            'attribute_name' => $attributeName,
        ];
    }

    public function createStrada(string $prefix, string $name, string $bridgeName = null): array
    {
        return $this->create("$prefix/$name", stub: __DIR__.'/../stubs/strada.stub', replacementsCallback: function (array $replacements) use ($bridgeName) {
            return array_merge(
                $replacements,
                ['[bridge-name]' => $bridgeName ?? (string) Str::of($replacements['[attribute]'])->afterLast('--')],
            );
        });
    }

    private function controllerName(string $name): string
    {
        return Str::of($name)->replace('_controller', '')->snake('_');
    }

    private function attributeName(string $name): string
    {
        return Str::of($this->controllerName($name))->replace('/', '--')->replace('_', '-');
    }
}
