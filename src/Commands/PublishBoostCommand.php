<?php

namespace HotwiredLaravel\StimulusLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PublishBoostCommand extends Command
{
    public $signature = 'stimulus:publish-boost {--bridge : Publish the Bridge Guideline} {--all : Publish all guidelines}';

    public $description = 'Publishes the Stimulus Boost Guideline.';

    public function handle()
    {
        $guidelines = array_values(array_filter([
            'stimulus.blade.php',
            $this->option('bridge') || $this->option('all') ? 'stimulus-bridge.blade.php' : null,
        ]));

        foreach ($guidelines as $guideline) {
            $from = dirname(__DIR__, levels: 2).DIRECTORY_SEPARATOR.'.ai'.DIRECTORY_SEPARATOR.$guideline;

            File::ensureDirectoryExists(base_path(implode(DIRECTORY_SEPARATOR, ['.ai', 'guidelines'])), recursive: true);
            File::copy($from, base_path(implode(DIRECTORY_SEPARATOR, ['.ai', 'guidelines', $guideline])));
        }

        $this->info('Boost guideline was published!');
    }
}
