<?php

namespace HotwiredLaravel\StimulusLaravel\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

class BladeControllerDirectiveTest extends TestCase
{
    use InteractsWithViews;

    #[\PHPUnit\Framework\Attributes\Test]
    public function binds_controller(): void
    {
        $this->blade('<div @controller(["hello"])></div>')
            ->assertSee('<div data-controller="hello"></div>', false);

        $this->blade('<div @controller("hello")></div>')
            ->assertSee('<div data-controller="hello"></div>', false);

        $this->blade('<div @controller(["hello", "something"])></div>')
            ->assertSee('<div data-controller="hello something"></div>', false);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function binds_values(): void
    {
        $this->blade(trim(<<<'BLADE'
            <div @controller(['hello' => ['value' => ['name' => 'Tony']]])></div>
        BLADE))
            ->assertSee('<div data-controller="hello" data-hello-name-value="Tony"></div>', false);

        $this->blade(trim(<<<'BLADE'
            <div @controller([
                'hello' => ['value' => ['name' => 'Tony']],
                'other' => ['value' => ['name' => 'Tester']],
            ])></div>
        BLADE))
            ->assertSee('<div data-controller="hello other" data-hello-name-value="Tony" data-other-name-value="Tester"></div>', false);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function binds_css_classes(): void
    {
        $this->blade(trim(<<<'BLADE'
            <div @controller(['hello' => ['class' => ['loading' => 'bg-gray-100 text-gray-900']]])></div>
        BLADE))
            ->assertSee('<div data-controller="hello" data-hello-loading-class="bg-gray-100 text-gray-900"></div>', false);

        $this->blade(trim(<<<'BLADE'
            <div @controller([
                'hello' => ['class' => ['loading' => 'bg-gray-100 text-gray-900']],
                'other' => ['class' => ['loading' => 'bg-blue-100 text-blue-900']],
            ])></div>
        BLADE))
            ->assertSee('<div data-controller="hello other" data-hello-loading-class="bg-gray-100 text-gray-900"'.
                ' data-other-loading-class="bg-blue-100 text-blue-900"></div>', false);
    }

    #[\PHPUnit\Framework\Attributes\Test]
    public function handles_mixed_bindings(): void
    {
        $this->blade(<<<'BLADE'
        <div @controller([
            'first',
            'second' => [
                'value' => ['name' => 'Tony'],
                'class' => ['loading' => 'bg-gray-100'],
            ],
            'third' => [
                'value' => ['name' => 'Tester'],
                'class' => ['loading' => 'bg-red-100'],
            ],
        ])></div>
        BLADE)
            ->assertSee('<div data-controller="first second third"'.
                ' data-second-name-value="Tony" data-second-loading-class="bg-gray-100"'.
                ' data-third-name-value="Tester" data-third-loading-class="bg-red-100"></div>', false);
    }
}
