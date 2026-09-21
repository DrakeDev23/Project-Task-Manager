<?php

namespace App\Notifications\Tasks;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskNotification extends Notification
{
    use Queueable;

    public function __construct(public Task $task, public string $type, public string $heading, public string $body) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $task = $this->task;
        $heading = $this->heading;
        $body = $this->body;
        $url = route('tasks.index').' #task-'.$task->id;

        return (new MailMessage)->subject($heading)->view(['emails.tasks.task', 'emails.tasks.task-text'], compact('task', 'heading', 'body', 'url'));
    }
}
