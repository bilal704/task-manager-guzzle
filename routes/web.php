<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index')->middleware('auth');
Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/tasks/create', [TaskController::class, 'create'])->name('tasks.create')->middleware('auth');
Route::get('/tasks/{id}/edit', [TaskController::class, 'edit'])->name('tasks.edit')->middleware('auth');
Route::put('/tasks/{id}', [TaskController::class, 'update'])->name('tasks.update')->middleware('auth');
Route::post('/tasks', [TaskController::class, 'store'])->name('tasks.store')->middleware('auth');
Route::get('/notifications', [TaskController::class, 'notifications'])->name('notifications')->middleware('auth');

Route::get('/tasks/delete', [TaskController::class, 'destroy'])->name('tasks.destroy')->middleware('auth');

Route::delete('/tasks/{id}', [TaskController::class, 'destroy'])->name('tasks.destroy')->middleware('auth');

Route::post('/notifications/{id}/read', [TaskController::class, 'markAsRead'])->name('notifications.read')->middleware('auth');

Route::get('test-email', function(){
    \Illuminate\Support\Facades\Mail::raw('Test Mail', function($msg){
        $msg->to('bilal.developer@mailinator.com')->subject('Test Email');

    });
    return redirect()->route('tasks.index')->with('setup-complete', 'Environment setup complete!');
});

Route::get('/upcoming-tasks', function () {
    $tomorrow = \Carbon\Carbon::now()->addDay();
    $tasks = \App\Models\Task::where('due_date', '>=', \Carbon\Carbon::now())
                             ->where('due_date', '<=', $tomorrow)
                             ->where('status', 'pending')
                             ->get();
    return view('upcoming-tasks', compact('tasks'));
})->name('upcoming-tasks')->middleware('auth');


Route::get('/week9-review', function () {
    $emailCount = \App\Models\CommandMessage::where('message', 'like', '%Reminder sent%')->count();
    return view('week9-review', compact('emailCount'));
})->name('week9-review');