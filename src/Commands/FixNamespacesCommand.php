<?php

namespace Hadialharbi\NestedComments\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixNamespacesCommand extends Command
{
    protected $signature = 'nested-comments:fix-namespaces';

    protected $description = 'Replace the namespace in published Livewire components';

    public function handle(): void
    {
        $path = app_path('Livewire/NestedComments');

        if (! File::exists($path)) {
            $this->error('Path not found: ' . $path);

            return;
        }

        $files = File::allFiles($path);

        foreach ($files as $file) {
            $contents = File::get($file->getRealPath());

            $updated = str_replace(
                'namespace Hadialharbi\\NestedComments\\Livewire;',
                'namespace App\\Livewire\\NestedComments;',
                $contents
            );

            File::put($file->getRealPath(), $updated);
        }

        $this->info('✅ Namespace updated in all published components.');
    }
}
