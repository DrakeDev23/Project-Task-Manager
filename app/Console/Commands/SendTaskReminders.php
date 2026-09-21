<?php

namespace App\Console\Commands;

use App\Models\Task;
use App\Models\TaskEmailNotification;
use App\Notifications\Tasks\TaskNotification;
use Illuminate\Console\Command;
use Illuminate\Database\QueryException;

class SendTaskReminders extends Command
{
    protected $signature = 'hapsay:send-task-reminders';

    protected $description = 'Send one due-soon or overdue Hapsay task email per task per day.';

    public function handle(): int
    {
        Task::query()->with('user')->where('status', '!=', 'completed')->whereNotNull('due_date')->each(function (Task $task) {
            $today = today();
            $type = $task->due_date->lt($today) ? 'overdue' : ($task->due_date->isSameDay($today->copy()->addDay()) ? 'due_soon' : null);
            if (! $type || ! $this->claim($task, $type, $today->toDateString())) {
                return;
            }
            $heading = $type === 'overdue' ? 'A Hapsay task is overdue' : 'You have an upcoming task';
            $message = $type === 'overdue' ? 'This task is overdue.' : 'This task is due tomorrow.';
            $task->user->notify(new TaskNotification($task, $type, $heading, $message));
        });

        return self::SUCCESS;
    }

    private function claim(Task $task, string $type, string $date): bool
    {
        try {
            TaskEmailNotification::create(['task_id' => $task->id, 'type' => $type, 'notified_for' => $date]);

            return true;
        } catch (QueryException) {
            return false;
        }
    }
}
