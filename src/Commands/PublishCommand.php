<?php

namespace HotwiredLaravel\StimulusLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class PublishCommand extends Command
{
    public $signature = 'stimulus:publish';

    public $description = 'Publishes the Stimulus assets.';

    public function handle(): int
    {
        if (! $this->usingImportmap()) {
            $this->components->warn('The assets are only meant for Importmaps Laravel.');

            return self::FAILURE;
        }

        $this->callSilently('vendor:publish', [
            '--tag' => 'stimulus-laravel-assets',
        ]);

        $this->comment('Done!');

        return self::SUCCESS;
    }

    private function usingImportmap(): bool
    {
        return File::exists(base_path('routes/importmap.php'));
    }
}
