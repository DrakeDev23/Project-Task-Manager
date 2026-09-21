@component('emails.layouts.message', ['title' => $heading])
<p>{{ $message }}</p><p><strong>{{ $task->title }}</strong>@if($task->due_date) — due {{ $task->due_date->format('M j, Y') }}@endif</p><p style="margin:28px 0"><a href="{{ $url }}" style="background:#1d4ed8;color:#fff;padding:12px 18px;border-radius:7px;text-decoration:none;font-weight:bold">View task</a></p>
@endcomponent
