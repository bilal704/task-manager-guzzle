@extends('layouts.app')
@section('content')
    <h1>Notifications</h1>
    @if(auth()->user()->notifications->isEmpty())
        <p>No notifications found.</p>
    @else
        <ul class="space-y-2">
            @foreach(auth()->user()->notifications as $notification)
                <li class="{{ $notification->read_at ? 'text-gray-500' : 'text-black' }}">
                    {{ $notification->message }} - {{ $notification->created_at->diffForHumans() }}
                    @if(!$notification->read_at)
                        <form method="POST" action="{{ route('notifications.read', $notification->id) }}" class="inline">
                            @csrf
                            <button type="submit" class="text-blue-500 ml-2">Mark as Read</button>
                        </form>
                    @endif
                </li>
            @endforeach
        </ul>
    @endif
@endsection