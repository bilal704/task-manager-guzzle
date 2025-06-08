@extends('layouts.app')
@section('content')
    <h1>Upcoming Tasks</h1>
    @if($tasks->isEmpty())
        <p>No upcoming tasks.</p>
    @else
        <ul class="upcoming-list">
            @foreach($tasks as $task)
                <li class="upcoming-item {{ $task->is_overdue ? 'overdue' : '' }}">
                    {{ $task->title }} - Due: {{ $task->due_date }}
                </li>
            @endforeach
        </ul>
    @endif
@endsection