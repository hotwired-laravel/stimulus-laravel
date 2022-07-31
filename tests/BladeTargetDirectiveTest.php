<?php

use Illuminate\Foundation\Testing\Concerns\InteractsWithViews;

uses(InteractsWithViews::class);

it('binds targets', function () {
    $this->blade(<<<'BLADE'
    <form data-controller="search checkbox">
        <input type="checkbox" @target(['search' => 'projects', 'checkbox' => 'input'])>
        <input type="checkbox" @target(['search' => 'messages', 'checkbox' => 'input'])>
    </form>
    BLADE)
        ->assertSee('<input type="checkbox" data-search-target="projects" data-checkbox-target="input">', false)
        ->assertSee('<input type="checkbox" data-search-target="messages" data-checkbox-target="input">', false);
});
