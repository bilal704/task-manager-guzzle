<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use GearmanWorker;

class GearmanWorkerCommand extends Command
{
    protected $signature = 'gearman:worker';
    protected $description = 'Run Gearman worker to process jobs';

    public function handle()
    {
        $worker = new GearmanWorker();
        $worker->addServer();
        $worker->addFunction('sendReminderEmail', function ($job) {
            $taskId = $job->workload();
            \Log::info("Sending reminder email for task ID: $taskId");
        });

        while ($worker->work());
    }
}