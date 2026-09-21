<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    public function dashboard()
    {
        $tasks = $this->authenticatedUser()->tasks()->latest()->get();
        $today = now()->startOfDay();

        return view('dashboard', [
            'tasks' => $tasks,
            'totalTasks' => $tasks->count(),
            'pendingTasks' => $tasks->where('status', 'pending')->count(),
            'completedTasks' => $tasks->where('status', 'completed')->count(),
            'upcomingTasks' => $tasks->filter(fn (Task $task) => $task->due_date && $task->due_date->greaterThanOrEqualTo($today) && $task->status !== 'completed')->sortBy('due_date')->values(),
        ]);
    }

    public function index()
    {
        return view('tasks.index', [
            'tasks' => $this->authenticatedUser()->tasks()->orderByRaw("case status when 'completed' then 1 else 0 end")->orderBy('due_date')->latest()->get(),
        ]);
    }

    public function calendar()
    {
        $tasks = $this->authenticatedUser()->tasks()->whereNotNull('due_date')->orderBy('due_date')->get();

        return view('tasks.calendar', [
            'calendarTasks' => $tasks->map(function (Task $task) {
                $color = match ($task->status) {
                    'completed' => '#10b981',
                    'pending' => '#f59e0b',
                    'in_progress' => '#3b82f6',
                    default => '#64748b',
                };

                if ($task->priority === 'high' && $task->status !== 'completed') {
                    $color = '#ef4444';
                }

                return [
                    'id' => $task->id,
                    'title' => $task->title,
                    'start' => $task->due_date->toDateString(),
                    'backgroundColor' => $color,
                    'borderColor' => $color,
                    'textColor' => '#ffffff',
                    'extendedProps' => [
                        'status' => $task->status,
                        'priority' => $task->priority,
                        'description' => $task->description,
                        'dueDate' => $task->due_date->format('M j, Y'),
                        'taskUrl' => route('tasks.index') . '#task-' . $task->id,
                    ],
                ];
            })->values(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $this->authenticatedUser()->tasks()->create($this->validatedTask($request, false));

        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    public function update(Request $request, Task $task): RedirectResponse
    {
        $this->authorizeTask($task);
        $task->update($this->validatedTask($request));

        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $this->authorizeTask($task);
        $task->delete();

        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }

    private function validatedTask(Request $request, bool $includeStatus = true): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'priority' => ['required', 'in:low,medium,high'],
            'due_date' => ['nullable', 'date'],
        ];

        if ($includeStatus) {
            $rules['status'] = ['required', 'in:pending,in_progress,completed'];
        }

        return $request->validate($rules);
    }

    private function authorizeTask(Task $task): void
    {
        abort_unless($task->user_id === Auth::id(), 403);
    }

    private function authenticatedUser(): User
    {
        return User::query()->findOrFail(Auth::id());
    }
}
