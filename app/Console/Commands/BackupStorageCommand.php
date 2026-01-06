<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class BackupStorageCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:backup {action=backup : backup or restore}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Backup or restore storage/app/public directory';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $action = $this->argument('action');
        $sourcePath = storage_path('app/public');
        $backupPath = storage_path('app/public_backup');

        if ($action === 'backup') {
            return $this->backup($sourcePath, $backupPath);
        } elseif ($action === 'restore') {
            return $this->restore($sourcePath, $backupPath);
        } else {
            $this->error('Invalid action. Use "backup" or "restore"');
            return 1;
        }
    }

    private function backup($sourcePath, $backupPath)
    {
        if (!File::exists($sourcePath)) {
            $this->error('Source directory does not exist: ' . $sourcePath);
            return 1;
        }

        if (File::exists($backupPath)) {
            if (!$this->confirm('Backup directory already exists. Overwrite?', false)) {
                $this->info('Backup cancelled.');
                return 0;
            }
            File::deleteDirectory($backupPath);
        }

        $this->info('Creating backup...');
        File::copyDirectory($sourcePath, $backupPath);
        
        $this->info('✓ Storage backed up successfully to: ' . $backupPath);
        return 0;
    }

    private function restore($sourcePath, $backupPath)
    {
        if (!File::exists($backupPath)) {
            $this->error('Backup directory does not exist: ' . $backupPath);
            return 1;
        }

        if (File::exists($sourcePath)) {
            if (!$this->confirm('This will overwrite current storage. Continue?', false)) {
                $this->info('Restore cancelled.');
                return 0;
            }
            File::deleteDirectory($sourcePath);
        }

        $this->info('Restoring from backup...');
        File::copyDirectory($backupPath, $sourcePath);
        
        $this->info('✓ Storage restored successfully from: ' . $backupPath);
        return 0;
    }
}
