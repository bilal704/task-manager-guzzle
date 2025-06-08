<!DOCTYPE html>
<html>
<head>
    <title>Tasks</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <h1>Tasks</h1>
    <!-- <form method="GET" action="{{ route('tasks.index') }}">
        <select name="status">
            <option value="">All</option>
            <option value="pending">Pending</option>
            <option value="completed">Completed</option>
        </select>
        <button type="submit">Filter</button>
    </form> -->
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
        <ul>
            @foreach($tasks as $task)
                <li>{{ $task->title }} ({{ $task->status }}) - Due: {{ $task->due_date }}</li>
            @endforeach
        </ul>
    @endif
</body>
</html>