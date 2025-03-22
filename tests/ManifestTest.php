<?php

namespace HotwiredLaravel\StimulusLaravel\Tests;

use HotwiredLaravel\StimulusLaravel\Manifest;

class ManifestTest extends TestCase
{
    #[\PHPUnit\Framework\Attributes\Test]
    public function generates_controllers_imports_given_a_path(): void
    {
        $manifest = (new Manifest)->generateFrom(implode(DIRECTORY_SEPARATOR, [
            __DIR__,
            'stubs',
            'controllers',
        ]).DIRECTORY_SEPARATOR)->join(PHP_EOL);

        $this->assertStringContainsString(
            <<<'JS'

            import HelloController from './hello_controller'
            Stimulus.register('hello', HelloController)
            JS,
            $manifest,
        );

        $this->assertStringContainsString(
            <<<'JS'

            import Nested__DeepController from './nested/deep_controller'
            Stimulus.register('nested--deep', Nested__DeepController)
            JS,
            $manifest,
        );

        $this->assertStringContainsString(
            <<<'JS'

            import CoffeeController from './coffee_controller'
            Stimulus.register('coffee', CoffeeController)
            JS,
            $manifest,
        );

        $this->assertStringContainsString(
            <<<'JS'

            import TypeScriptController from './type_script_controller'
            Stimulus.register('type-script', TypeScriptController)
            JS,
            $manifest,
        );

        $this->assertStringNotContainsString(
            <<<'JS'

            import Index from './index'
            Stimulus.register('index', Index)
            JS,
            $manifest,
        );
    }
}
