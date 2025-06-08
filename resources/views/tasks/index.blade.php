@extends('layouts.app')
@section('content')
    <h1>Tasks</h1>
    @if (session('success'))
        <div class="bg-green-200 text-green-700 p-4 rounded-md mb-4">
            {{ session('success') }}
        </div>
    @endif
    <form method="GET" action="{{ route('tasks.index') }}">
        <input type="text" name="search" placeholder="Search tasks..." value="{{ request('search') }}">
        <select name="status">
            <option value="">All</option>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
        </select>
        <input type="date" name="due_date" value="{{ request('due_date') }}">
        <select name="sort">
            <option value="due_date">Due Date</option>
            <option value="title">Title</option>
        </select>
        <select name="direction">
            <option value="asc">Ascending</option>
            <option value="desc">Descending</option>
        </select>
        <button type="submit">Filter & Sort</button>
    </form>
    @if($tasks->isEmpty())
        <p>No tasks found.</p>
    @else
        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-100">
                    <th class="border px-4 py-2">Title</th>
                    <th class="border px-4 py-2">Status</th>
                    <th class="border px-4 py-2">Due Date</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($tasks as $task)
                    <tr class="{{ $loop->even ? 'bg-gray-50' : 'bg-white' }}">
                        <td data-label="Title" class="border px-4 py-2">{{ $task->title }}</td>
                        <td data-label="Status" class="border px-4 py-2 {{ $task->status == 'completed' ? 'text-green-600' : 'text-red-600' }}">{{ $task->status }}</td>
                        <td data-label="Due Date" class="border px-4 py-2">{{ $task->due_date }}</td>
                        <td data-label="Actions" class="border px-4 py-2">
                            <a href="{{ route('tasks.edit', $task->id) }}" class="text-blue-500">Edit</a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-500">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
@endsection