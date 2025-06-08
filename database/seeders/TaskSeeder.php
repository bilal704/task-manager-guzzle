<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Task;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
public function run(): void
    {
        //Task::create(['title' => 'Plan sprint', 'status' => 'pending', 'due_date' => '2025-05-15']);
        //Task::create(['title' => 'Write documentation', 'status' => 'completed', 'due_date' => '2025-05-20']);

        $user = \App\Models\User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
        ]);
        Task::create(['title' => 'Plan sprint', 'status' => 'pending', 'due_date' => '2025-05-15', 'user_id' => $user->id]);
        Task::create(['title' => 'Write documentation', 'status' => 'completed', 'due_date' => '2025-05-20', 'user_id' => $user->id]);
    }
}
