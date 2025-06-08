<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /*public function index(Request $request){

        /*$status = $request->query('status');
        $tasks = $status ? Task::where('status', $status)->get() : Task::all();
        return view('tasks.index', compact('tasks'));*/

        /*$status = $request->query('status');
        $sort = $request->query('sort', 'due_date');
        $direction = $request->query('direction', 'asc');
        $query = Task::query();
        if ($status) {
            $query->where('status', $status);
        }
        $tasks = $query->orderBy($sort, $direction)->get();
        return view('tasks.index', compact('tasks'));*/

        /*$search = $request->query('search');
        $status = $request->query('status');
        $dueDate = $request->query('due_date');
        $sort = $request->query('sort', 'due_date');
        $direction = $request->query('direction', 'asc');
        $tasks = collect();

        if($search){
            $tasks = Task::search($search);
        }
        else{
            $query = Task::query();
            if($status){
                $query->where('status', $status);
            }
            if($dueDate){
                $query->where('due_date', '<=', $dueDate);
            }
            $tasks = $query->orderBy($sort, $direction)->get();
        }

        return view('tasks.index', compact('tasks'));
    }*/

    public function index(Request $request)
    {
        $search = $request->query('search');
        $status = $request->query('status');
        $dueDate = $request->query('due_date');
        $sort = $request->query('sort', 'due_date');
        $direction = $request->query('direction', 'asc');
        $tasks = collect();
        if ($search) {
            $tasks = Task::search($search)->where('user_id', auth()->id())->get();
            if ($tasks->isEmpty()) {
                \Log::info('No search results found for query: ' . $search);
            }
        } else {
            $query = Task::where('user_id', auth()->id());
            if ($status) {
                $query->where('status', $status);
            }
            if ($dueDate) {
                $query->where('due_date', '<=', $dueDate);
            }
            $tasks = $query->orderBy($sort, $direction)->get();
        }
        return view('tasks.index', compact('tasks'));
    }

    public function create(){
        return view('tasks.create');
    }

    public function edit($id)
    {
        $task = auth()->user()->tasks()->findOrFail($id);
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, $id)
    {
        $task = auth()->user()->tasks()->findOrFail($id);
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'status' => 'required|in:pending,completed',
            'due_date' => 'nullable|date',
        ]);
        $task->update($validated);
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully');
    }

    public function store(Request $request){

        $request->validate([
            'title'     => 'required|string|max:255',
            'status'    => 'required|in:pending,completed',
            'due_date'  => 'nullable|date' 
        ]);
        
        Task::create([
            'title'     => $request->title,
            'status'    => $request->status,
            'due_date'  => $request->due_date,
            'user_id'   => auth()->id()
        ]);

        auth()->user()->notifications()->create([
            'message' => "Task '{$request->title}' created successfully.",
        ]);

        return redirect()->route('tasks.index');
    }

    public function notifications()
    {
        return view('notifications');
    }

    public function destroy($id)
    {
        $task = auth()->user()->tasks()->findOrFail($id);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully');
    }

    public function markAsRead($id)
    {   
        $notification = auth()->user()->notifications()->findOrFail($id);
        $notification->read_at = now();
        $notification->save();
        return redirect()->back();
    }
}
