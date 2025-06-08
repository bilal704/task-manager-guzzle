<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\CommandMessage;

class CleanCommandMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages:clean';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clean up displayed command messages older than 1 day';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        CommandMessage::where('displayed', true)
                      ->where('created_at', '<', now()->subDay())
                      ->delete();
        $this->info('Cleaned up old command messages.');
    }
}
