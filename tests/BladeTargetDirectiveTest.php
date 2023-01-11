<?php

namespace Tonysm\StimulusLaravel\Tests;

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

class BladeTargetDirectiveTest extends TestCase
{
    use InteractsWithViews;

    /** @test */
    public function binds_targets()
    {
        $this->blade(<<<'BLADE'
            <form data-controller="search checkbox">
                <input type="checkbox" @target(['search' => 'projects', 'checkbox' => 'input'])>
                <input type="checkbox" @target(['search' => 'messages', 'checkbox' => 'input'])>
            </form>
            BLADE)
            ->assertSee('<input type="checkbox" data-search-target="projects" data-checkbox-target="input">', false)
            ->assertSee('<input type="checkbox" data-search-target="messages" data-checkbox-target="input">', false);
    }
}
