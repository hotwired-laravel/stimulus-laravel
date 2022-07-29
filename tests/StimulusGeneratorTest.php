<?php

use Illuminate\Support\Facades\File;
use Tonysm\StimulusLaravel\StimulusGenerator;

beforeEach(function () {
    $this->tmpFolder = sys_get_temp_dir().'/stimulus-laravel-test';

    File::ensureDirectoryExists($this->tmpFolder);
    File::cleanDirectory($this->tmpFolder);
});

it('creates stimulus controller with regular name', function () {
    (new StimulusGenerator($this->tmpFolder))
        ->create('hello');

    expect(File::exists($file = $this->tmpFolder.'/hello_controller.js'))->toBeTrue();
    expect(File::get($file))->toContain('data-controller="hello"');
});

it('removes controller suffix when used', function () {
    (new StimulusGenerator($this->tmpFolder))
        ->create('hello_controller');

    expect(File::exists($file = $this->tmpFolder.'/hello_controller.js'))->toBeTrue();
    expect(File::get($file))->toContain('data-controller="hello"');
});

it('generates controller names with sub-folders', function () {
    $file = (new StimulusGenerator($this->tmpFolder))
        ->create('nested/hello_controller');

    expect(File::exists($file = $this->tmpFolder.'/nested/hello_controller.js'))->toBeTrue();
    expect(File::get($file))->toContain('data-controller="nested--hello"');
});
