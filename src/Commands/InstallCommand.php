<?php

namespace HotwiredLaravel\StimulusLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Symfony\Component\Process\Process;
use RuntimeException;

class InstallCommand extends Command
{
    use Concerns\InstallsForImportmap;
    use Concerns\InstallsForNode;

    public $signature = 'stimulus:install {--strada : Sets up Strada as well.}';

    public $description = 'Installs the Stimulus Laravel package.';

    protected $afterMessages = [];

    public function handle(): int
    {
        $this->components->info('Installing Stimulus Laravel');

        if ($this->usingImportmaps()) {
            $this->installsForImportmaps();
        } else {
            $this->installsForNode();

            if (file_exists(base_path('pnpm-lock.yaml'))) {
                $this->runCommands(['pnpm install', 'pnpm run build']);
            } elseif (file_exists(base_path('yarn.lock'))) {
                $this->runCommands(['yarn install', 'yarn run build']);
            } else {
                $this->runCommands(['npm install', 'npm run build']);
            }
        }

        $this->newLine();
        $this->components->info('Done');
        $this->newLine();

        return self::SUCCESS;
    }

    protected function jsPackages(): array
    {
        return array_merge(
            ['@hotwired/stimulus' => '^3.1.0'],
            $this->hasOption('strada') ? ['@hotwired/strada' => '^1.0.0-beta1'] : [],
        );
    }

    /**
     * Run the given commands.
     *
     * @param  array  $commands
     * @return void
     */
    protected function runCommands($commands)
    {
        $process = Process::fromShellCommandline(implode(' && ', $commands), null, null, null, null);

        if ('\\' !== DIRECTORY_SEPARATOR && file_exists('/dev/tty') && is_readable('/dev/tty')) {
            try {
                $process->setTty(true);
            } catch (RuntimeException $e) {
                $this->output->writeln('  <bg=yellow;fg=black> WARN </> '.$e->getMessage().PHP_EOL);
            }
        }

        $process->run(function ($type, $line) {
            $this->output->write('    '.$line);
        });
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
