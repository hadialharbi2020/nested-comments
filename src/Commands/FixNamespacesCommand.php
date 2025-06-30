<?php

namespace Hadialharbi\NestedComments\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class FixNamespacesCommand extends Command
{
    protected $signature = 'nested-comments:fix-namespaces';

    protected $description = 'Replace the namespace in published Livewire components and related classes';

    public function handle(): void
    {
        $livewirePath = app_path('Livewire/NestedComments');
        $filamentActionPath = app_path('Filament/Actions/CommentsAction.php');

        // ✅ تحديث Livewire components
        if (File::exists($livewirePath)) {
            $files = File::allFiles($livewirePath);

            foreach ($files as $file) {
                $contents = File::get($file->getRealPath());

                $updated = str_replace(
                    'namespace Hadialharbi\\NestedComments\\Livewire;',
                    'namespace App\\Livewire\\NestedComments;',
                    $contents
                );

                File::put($file->getRealPath(), $updated);
            }

            $this->info('✅ Namespace updated in Livewire components.');
        } else {
            $this->warn('⚠️ Livewire path not found: ' . $livewirePath);
        }

        // ✅ تحديث CommentsAction
        if (File::exists($filamentActionPath)) {
            $contents = File::get($filamentActionPath);

            $updated = str_replace(
                'namespace Hadialharbi\\NestedComments\\Filament\\Actions;',
                'namespace App\\Filament\\Actions;',
                $contents
            );

            File::put($filamentActionPath, $updated);

            $this->info('✅ Namespace updated in CommentsAction.php.');
        } else {
            $this->warn('⚠️ CommentsAction.php not found: ' . $filamentActionPath);
        }

        $tableActionPath = app_path('Filament/Tables/Actions/CommentsAction.php');

        if (File::exists($tableActionPath)) {
            $contents = File::get($tableActionPath);

            $updated = str_replace(
                'namespace Hadialharbi\\NestedComments\\Filament\\Tables\\Actions;',
                'namespace App\\Filament\\Tables\\Actions;',
                $contents
            );

            File::put($tableActionPath, $updated);

            $this->info('✅ Namespace updated in Table CommentsAction.php.');
        } else {
            $this->warn('⚠️ Table CommentsAction.php not found: ' . $tableActionPath);
        }

        $this->info('🎉 Namespace fix completed.');
    }
}
