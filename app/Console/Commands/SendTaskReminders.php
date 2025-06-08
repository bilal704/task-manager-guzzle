<?php

namespace App\Console\Commands;

use App\Mail\TaskReminder;
use Illuminate\Console\Command;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use App\Models\CommandMessage;

class SendTaskReminders extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:send-reminders';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send reminders for tasks due within 24 hours';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Task reminders command executed successfully.');
        //\Illuminate\Support\Facades\Session::flash('command-message', 'Reminder command ran successfully!');
        // Logic will be added tomorrow
        $tomorrrow = Carbon::now()->addDay();
        $tasks = Task::where('due_date', '>=', Carbon::now())
                    ->where('due_date', '<=', $tomorrrow)
                    ->where('status', 'pending')
                    ->get();
        
        foreach($tasks as $task){
            //Mail::to($task->user->email)->send(new TaskReminder($task));
            $this->info("Reminder: Task '{$task->title}' is due on {$task->due_date}");

            // Store a message for the user
            CommandMessage::create([
                'user_id' => $task->user->id,
                'message' => "Reminder sent for task '{$task->title}' at " . now(),
            ]);
        }
    }
}
