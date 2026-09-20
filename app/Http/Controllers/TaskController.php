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
