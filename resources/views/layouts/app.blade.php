<!DOCTYPE html>
<html>
<head>
    <title>Task Manager</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    @if(session('setup-complete'))
        <div class="setup-message">
            {{ session('setup-complete') }}
        </div>
    @endif
    @if(session('command-message'))
        <div class="command-message">
            {{ session('command-message') }}
        </div>
    @endif
    @if(auth()->check() && auth()->user()->commandMessages()->where('displayed', false)->count() > 0)
        @foreach(auth()->user()->commandMessages()->where('displayed', false)->get() as $message)
            <div class="command-message {{ str_contains($message->message, 'Gearman setup') ? 'gearman-setup' : (str_contains($message->message, 'scheduled successfully') ? 'schedule-success' : (str_contains($message->message, 'scheduler set up') ? 'scheduler-setup' : '')) }}">
                <span class="message-icon">📬</span> {{ $message->message }}
            </div>
            @php
                $message->update(['displayed' => true]);
            @endphp
        @endforeach
    @endif
    <nav class="bg-gray-800 text-white p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="{{ route('tasks.index') }}" class="text-lg font-bold">Task Manager</a>
            <button id="menu-toggle" class="block md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7" />
                </svg>
            </button>
            <div id="menu" class="hidden md:flex md:items-center">
                @auth
                    <a href="{{ route('tasks.index') }}" class="mr-4">Tasks</a>
                    <a href="{{ route('tasks.create') }}" class="mr-4">Create Task</a>
                    <div class="relative">
                        <a href="{{ route('notifications') }}">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                            </svg>
                            @if(auth()->user()->notifications()->whereNull('read_at')->count() > 0)
                                <span class="absolute top-0 right-0 bg-red-500 text-white text-xs rounded-full px-2">{{ auth()->user()->notifications()->whereNull('read_at')->count() }}</span>
                            @endif
                        </a>
                    </div>
                    <a href="{{ route('week9-review') }}" class="mr-4">Week 9 Review</a>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="ml-4">Logout</a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                        @csrf
                    </form>
                @else
                    <a href="{{ route('login') }}" class="mr-4">Login</a>
                    <a href="{{ route('register') }}">Register</a>
                @endauth
            </div>
        </div>
    </nav>
    <div class="container mx-auto p-4">
        @yield('content')
    </div>
</body>
</html>