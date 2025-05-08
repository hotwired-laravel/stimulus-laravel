<?php

namespace HotwiredLaravel\StimulusLaravel\Commands;

class CoreMakeCommand extends MakeCommand
{
    public $signature = 'make:stimulus {name : The Controller name} {--bridge= : The name of the bridge component to be created}';
}
