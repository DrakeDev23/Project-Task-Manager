{{ $heading }}
{{ $message }}
{{ $task->title }}@if($task->due_date) — due {{ $task->due_date->format('M j, Y') }}@endif
View task: {{ $url }}
