<?php

namespace Tonysm\StimulusLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    use Concerns\InstallsForImportmap;
    use Concerns\InstallsForNode;

    public $signature = 'stimulus:install';

    public $description = 'Installs the Stimulus Laravel package.';

    public function handle(): int
    {
        if ($this->usingImportmaps()) {
            $this->installsForImportmaps();
        } else {
            $this->installsForNode();
        }

        $this->comment('Done!');

        return self::SUCCESS;
    }

    protected function usingImportmaps(): bool
    {
        return File::exists($this->importmapsFile());
    }

    protected function importmapsFile(): string
    {
        return base_path('routes/importmap.php');
    }
}
