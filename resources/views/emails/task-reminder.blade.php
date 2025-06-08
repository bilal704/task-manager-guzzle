@component('mail::message')
# Task Reminder

# Your task **{{ $task->title }}** is due on {{ $task->due_date }}.

<div style="background-color: #e0e0e0; padding: 15px; border-radius: 5px;">
    Your task <strong>{{ $task->title }}</strong> is due on {{ $task->due_date }}.
</div>

Please complete it soon!

Thanks,
Task Manager Team
@endcomponent