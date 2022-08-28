<?php

namespace Tonysm\StimulusLaravel\Commands;

use Illuminate\Console\Command;

class ManifestCommand extends Command
{
    public $signature = 'stimulus:manifest';
    public $description = 'Updates the manifest based on the existing Stimulus controllers.';

    public function handle()
    {
        // 1. Find all controllers in the controller's path (config?) with nested folders
        // 2. Delete the `controllers/index.js` file
        // 3. Regenerate the `controllers/index.js` file with the up-to-date controllers

        return self::SUCCESS;
    }
}
