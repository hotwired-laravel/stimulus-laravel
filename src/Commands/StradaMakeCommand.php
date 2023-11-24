<?php

namespace HotwiredLaravel\StimulusLaravel\Commands;

use HotwiredLaravel\StimulusLaravel\StimulusGenerator;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Process;

class StradaMakeCommand extends Command
{
    public $signature = 'strada:make
                            {name : The Strada Component name (without bridge prefix.}
                            {--prefix=bridge : The component prefix.}
                            {--bridge-name= : The name of the native component.}';

    public $description = 'Makes a new Strada Component.';

    public function handle(StimulusGenerator $generator): int
    {
        $this->components->info('Making Strada Component');

        $this->components->task('creating strada component', function () use ($generator) {
            $generator->createStrada($this->option('prefix'), $this->argument('name'), $this->option('bridge-name'));

            return true;
        });

        if (! File::exists(base_path('routes/importmap.php'))) {
            $this->components->task('regenerating manifest', function () {
                return $this->callSilently(ManifestCommand::class);
            });

            if (file_exists(base_path('pnpm-lock.yaml'))) {
                Process::forever()->path(base_path())->run(['pnpm', 'run', 'build']);
            } elseif (file_exists(base_path('yarn.lock'))) {
                Process::forever()->path(base_path())->run(['yarn', 'run', 'build']);
            } else {
                Process::forever()->path(base_path())->run(['npm', 'run', 'build']);
            }
        }

        $this->newLine();
        $this->components->info('Done');

        return self::SUCCESS;
    }
}
