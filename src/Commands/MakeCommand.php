<?php

namespace Tonysm\StimulusLaravel\Commands;

use Illuminate\Console\Command;
use Tonysm\StimulusLaravel\StimulusGenerator;

class MakeCommand extends Command
{
    public $signature = 'stimulus:make {name : The Controller name}';

    public $description = 'Makes a new Stimulus Controller.';

    public function handle(StimulusGenerator $generator): int
    {
        $generator->create($this->argument('name'));

        $this->comment('Done!');

        return self::SUCCESS;
    }
}
