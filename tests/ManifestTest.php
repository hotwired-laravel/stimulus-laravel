<?php

namespace Hotwired\StimulusLaravel\Tests;

use Hotwired\StimulusLaravel\Manifest;

class ManifestTest extends TestCase
{
    /** @test */
    public function generates_controllers_imports_given_a_path()
    {
        $join = function ($paths) {
            return implode(DIRECTORY_SEPARATOR, $paths);
        };
        $manifest = (new Manifest)->generateFrom($join([
            __DIR__,
            'stubs',
            'controllers',
        ]).DIRECTORY_SEPARATOR)->join(PHP_EOL);

        $this->assertStringContainsString(
            <<<JS

            import HelloController from '{$join(['.', 'hello_controller'])}'
            application.register('hello', HelloController)
            JS,
            $manifest,
        );

        $this->assertStringContainsString(
            <<<JS

            import Nested__DeepController from '{$join(['.', 'nested', 'deep_controller'])}'
            application.register('nested--deep', Nested__DeepController)
            JS,
            $manifest,
        );

        $this->assertStringContainsString(
            <<<JS

            import CoffeeController from '{$join(['.', 'coffee_controller'])}'
            application.register('coffee', CoffeeController)
            JS,
            $manifest,
        );

        $this->assertStringContainsString(
            <<<JS

            import TypeScriptController from '{$join(['.', 'type_script_controller'])}'
            application.register('type-script', TypeScriptController)
            JS,
            $manifest,
        );

        $this->assertStringNotContainsString(
            <<<JS

            import Index from '{$join(['.', 'index'])}'
            application.register('index', Index)
            JS,
            $manifest,
        );
    }
}
