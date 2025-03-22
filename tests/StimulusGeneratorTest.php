<?php

namespace HotwiredLaravel\StimulusLaravel\Tests;

use HotwiredLaravel\StimulusLaravel\StimulusGenerator;
use Illuminate\Support\Facades\File;
use PHPUnit\Framework\Attributes\Test;

class StimulusGeneratorTest extends TestCase
{
    private string $tmpFolder;

    protected function setUp(): void
    {
        parent::setUp();

        $this->tmpFolder = sys_get_temp_dir() . '/stimulus-laravel-test';

        File::ensureDirectoryExists($this->tmpFolder);
        File::cleanDirectory($this->tmpFolder);
    }

    #[Test]
    public function creates_stimulus_controller_with_regular_name()
    {
        (new StimulusGenerator($this->tmpFolder))
            ->create('hello');

        $this->assertTrue(File::exists($file = $this->tmpFolder . '/hello_controller.js'));
        $this->assertStringContainsString('data-controller="hello"', File::get($file));
    }

    #[Test]
    public function removes_controller_suffix_when_used()
    {
        (new StimulusGenerator($this->tmpFolder))
            ->create('hello_controller');

        $this->assertTrue(File::exists($file = $this->tmpFolder . '/hello_controller.js'));
        $this->assertStringContainsString('data-controller="hello"', File::get($file));
    }

    #[Test]
    public function generates_controller_with_subfolders()
    {
        $file = (new StimulusGenerator($this->tmpFolder))
            ->create('nested/hello_controller');

        $this->assertTrue(File::exists($file = $this->tmpFolder . '/nested/hello_controller.js'));
        $this->assertStringContainsString('data-controller="nested--hello"', File::get($file));
    }
}
