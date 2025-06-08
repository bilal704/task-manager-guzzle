<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class DatabaseBackup extends Command
{
    protected $signature = 'db:backup';
    protected $description = 'Backup the database';

    public function handle()
    {
        $filename = 'backup-' . now()->format('Y-m-d') . '.sql';
        $command = "mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " " . env('DB_DATABASE') . " > " . storage_path($filename);
        exec($command);
        $this->info("Database backed up to $filename");
    }
}