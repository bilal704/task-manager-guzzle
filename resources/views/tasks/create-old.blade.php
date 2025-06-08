<!DOCTYPE html>
<html>
<head>
    <title>Create Task</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <h1>Create Task</h1>
    <form method="POST" action="{{ route('tasks.store') }}">
        @csrf
        <div>
            <label>Title</label>
            <input type="text" name="title" required>
        </div>
        <div>
            <label>Status</label>
            <select name="status">
                <option value="pending">Pending</option>
                <option value="completed">Completed</option>
            </select>
        </div>
        <div>
            <label>Due Date</label>
            <input type="date" name="due_date">
        </div>
        <button type="submit">Create Task</button>
    </form>
    <a href="{{ route('tasks.index') }}">Back to Tasks</a>
</body>
</html>