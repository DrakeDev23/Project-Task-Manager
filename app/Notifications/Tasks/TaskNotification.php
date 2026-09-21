<?php

namespace App\Notifications\Tasks;

use App\Models\Task;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

/** A reusable task-mail notification for reminders, assignment, and completion events. */
class TaskNotification extends Notification
{
    use Queueable;

    public function __construct(public Task $task, public string $type, public string $heading, public string $message) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $task = $this->task;
        $heading = $this->heading;
        $message = $this->message;
        $url = route('tasks.index').'#task-'.$task->id;

        return (new MailMessage)->subject($heading)->view(['emails.tasks.task', 'emails.tasks.task-text'], compact('task', 'heading', 'message', 'url'));
    }
}
