<?php

namespace Tonysm\StimulusLaravel\Tests;

use Tonysm\StimulusLaravel\Manifest;

class ManifestTest extends TestCase
{
    /** @test */
    public function generates_controllers_imports_given_a_path()
    {
        $manifest = (new Manifest)->generateFrom(implode(DIRECTORY_SEPARATOR, [
            __DIR__,
            'stubs',
            'controllers',
        ]) . DIRECTORY_SEPARATOR)->join(PHP_EOL);

        $this->assertStringContainsString(
            <<<'JS'

            import HelloController from './hello_controller'
            application.register('hello', HelloController)
            JS,
            $manifest,
        );

        $this->assertStringContainsString(
            <<<'JS'

            import Nested__DeepController from './nested/deep_controller'
            application.register('nested--deep', Nested__DeepController)
            JS,
            $manifest,
        );

        $this->assertStringContainsString(
            <<<'JS'

            import CoffeeController from './coffee_controller'
            application.register('coffee', CoffeeController)
            JS,
            $manifest,
        );

        $this->assertStringContainsString(
            <<<'JS'

            import TypeScriptController from './type_script_controller'
            application.register('type-script', TypeScriptController)
            JS,
            $manifest,
        );

        $this->assertStringNotContainsString(
            <<<'JS'

            import Index from './index'
            application.register('index', Index)
            JS,
            $manifest,
        );
    }
}
