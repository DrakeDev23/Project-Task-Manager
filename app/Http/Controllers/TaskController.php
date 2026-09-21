<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\User;
use App\Notifications\Tasks\TaskNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class TaskController extends Controller
{
    public function dashboard()
    {
        $user = $this->authenticatedUser();

        $today = now()->startOfDay();

        $total = $user->tasks()->count();
        $inProgress = $user->tasks()->where('status', 'in_progress')->count();
        $completed = $user->tasks()->where('status', 'completed')->count();
        $pending = $user->tasks()->where('status', 'pending')->count();
        $overdue = $user->tasks()->whereNotNull('due_date')->where('due_date', '<', $today)->where('status', '!=', 'completed')->count();

        $recentTasks = $user->tasks()->with('category')->latest()->take(5)->get();

        $upcomingTasks = $user->tasks()
            ->whereNotNull('due_date')
            ->where('status', '!=', 'completed')
            ->where('due_date', '>=', $today)
            ->orderBy('due_date')
            ->take(5)
            ->get();

        return view('dashboard', [
            'totalTasks' => $total,
            'inProgress' => $inProgress,
            'completedTasks' => $completed,
            'pendingTasks' => $pending,
            'overdue' => $overdue,
            'recentTasks' => $recentTasks,
            'upcomingTasks' => $upcomingTasks,
        ]);
    }

    public function index(Request $request)
    {
        $user = $this->authenticatedUser();

        $query = $user->tasks()->with('category')->orderByRaw("case status when 'completed' then 1 else 0 end")->orderBy('due_date')->latest();

        if ($request->filled('category')) {
            $query->where('category_id', $request->input('category'));
        }

        $tasks = $query->paginate(5)->withQueryString();

        return view('tasks.index', [
            'tasks' => $tasks,
            'categories' => $user->categories()->orderBy('name')->get(),
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
                        'taskUrl' => route('tasks.index').'#task-'.$task->id,
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
        $wasCompleted = $task->status === 'completed';
        $task->update($this->validatedTask($request));
        if (! $wasCompleted && $task->status === 'completed') {
            $task->user->notify(new TaskNotification($task, 'completed', 'Task completed in Hapsay', 'You completed this task.'));
        }

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
            'category_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id')->where(fn ($query) => $query->where('user_id', Auth::id())),
            ],
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
