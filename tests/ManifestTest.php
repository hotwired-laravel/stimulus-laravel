<?php

use Tonysm\StimulusLaravel\Manifest;

it('generates controllers imports given a path', function () {
    $manifest = (new Manifest)->generateFrom(__DIR__ . '/stubs/controllers/')->join(PHP_EOL);

    expect($manifest)
        ->toContain(
            <<<JS

            import HelloController from './hello_controller'
            application.register('hello', HelloController)
            JS
        )
        ->toContain(
            <<<JS

            import Nested__DeepController from './nested/deep_controller'
            application.register('nested--deep', Nested__DeepController)
            JS
        )
        ->toContain(
            <<<JS

            import CoffeeController from './coffee_controller'
            application.register('coffee', CoffeeController)
            JS
        )
        ->toContain(
            <<<JS

            import TypeScriptController from './type_script_controller'
            application.register('type-script', TypeScriptController)
            JS
        )
        ->not->toContain(
            <<<JS

            import Index from './index'
            application.register('index', Index)
            JS
        );
});
