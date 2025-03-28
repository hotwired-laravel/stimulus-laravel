<?php

namespace HotwiredLaravel\StimulusLaravel\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use RuntimeException;
use Symfony\Component\Process\PhpExecutableFinder;
use Symfony\Component\Process\Process;

class InstallCommand extends Command
{
    use Concerns\InstallsForImportmap;
    use Concerns\InstallsForNode;

    public $signature = 'stimulus:install {--strada : Sets up Strada as well.}';

    public $description = 'Installs the Stimulus Laravel package.';

    protected $afterMessages = [];

    public function handle(): int
    {
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

        $this->components->info('Stimulus Laravel was installed successfully.');

        return self::SUCCESS;
    }

    protected function jsPackages(): array
    {
        return array_merge(
            ['@hotwired/stimulus' => '^3.2'],
            $this->hasOption('strada') ? ['@hotwired/hotwire-native-bridge' => '^1.1'] : [],
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

        $process->run(function ($type, string $line): void {
            $this->output->write('    '.$line);
        });
    }

    protected function phpBinary(): string
    {
        return (new PhpExecutableFinder)->find(false) ?: 'php';
    }

    private function usingImportmaps(): bool
    {
        return File::exists($this->importmapsFile());
    }

    private function importmapsFile(): string
    {
        return base_path('routes/importmap.php');
    }
}
