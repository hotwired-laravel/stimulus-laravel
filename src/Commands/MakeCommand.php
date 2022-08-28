<?php

namespace Tonysm\StimulusLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Tonysm\StimulusLaravel\StimulusGenerator;

class MakeCommand extends Command
{
    public $signature = 'stimulus:make {name : The Controller name}';

    public $description = 'Makes a new Stimulus Controller.';

    public function handle(StimulusGenerator $generator): int
    {
        $generator->create($this->argument('name'));

        if (! File::exists(base_path('routes/importmap.php'))) {
            $this->call('stimulus:manifes');
        }

        $this->comment('Done!');

        return self::SUCCESS;
    }
}
