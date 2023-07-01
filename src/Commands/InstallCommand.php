<?php

namespace HotwiredLaravel\StimulusLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InstallCommand extends Command
{
    use Concerns\InstallsForImportmap;
    use Concerns\InstallsForNode;

    public $signature = 'stimulus:install';

    public $description = 'Installs the Stimulus Laravel package.';

    protected $afterMessages = [];

    public function handle(): int
    {
        $this->components->info('Installing Stimulus Laravel');

        if ($this->usingImportmaps()) {
            $this->installsForImportmaps();
        } else {
            $this->installsForNode();
        }

        if (! empty($this->afterMessages)) {
            $this->newLine();
            $this->components->info('After Notes and Next Steps');
            $this->components->bulletList($this->afterMessages);
        } else {
            $this->components->info('Done');
        }

        $this->newLine();

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
