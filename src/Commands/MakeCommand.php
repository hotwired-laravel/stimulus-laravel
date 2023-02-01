<?php

namespace Hotwired\StimulusLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Hotwired\StimulusLaravel\StimulusGenerator;

class MakeCommand extends Command
{
    public $signature = 'stimulus:make {name : The Controller name}';

    public $description = 'Makes a new Stimulus Controller.';

    public function handle(StimulusGenerator $generator): int
    {
        $this->components->info('Making Stimulus Controller');

        $this->components->task('creating controller', function () use ($generator) {
            $generator->create($this->argument('name'));

            return true;
        });

        if (! File::exists(base_path('routes/importmap.php'))) {
            $this->components->task('regenerating manifest', function () {
                return $this->callSilently(ManifestCommand::class);
            });
        }

        $this->newLine();
        $this->components->info('Done');

        return self::SUCCESS;
    }
}
