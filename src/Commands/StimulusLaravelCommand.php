<?php

namespace Tonysm\StimulusLaravel\Commands;

use Illuminate\Console\Command;

class StimulusLaravelCommand extends Command
{
    public $signature = 'stimulus-laravel';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}
