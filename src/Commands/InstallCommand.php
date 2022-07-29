<?php

namespace Tonysm\StimulusLaravel\Commands;

use Illuminate\Console\Command;

class InstallCommand extends Command
{
    public $signature = 'stimulus:install';

    public $description = 'Installs the Stimulus Laravel package.';

    public function handle(): int
    {
        $this->comment('Done!');

        return self::SUCCESS;
    }
}
