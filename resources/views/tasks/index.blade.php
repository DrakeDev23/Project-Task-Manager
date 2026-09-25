<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Tasks · Hapsay</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">

    <div class="flex min-h-screen">

        @include('partials.sidebar')

        <main id="mainContent" class="ml-64 min-h-screen flex-1 transition-[margin] duration-300 ease-in-out">

            <div class="mx-auto max-w-7xl px-6 py-10 lg:px-8">

                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.16em] text-blue-700">Task management</p>
                    <h1 class="mt-2 text-3xl font-semibold tracking-tight">Your tasks</h1>
                    <p class="mt-2 text-slate-500">Keep every commitment visible and moving.</p>
                </div>

                @if (session('success'))
                    <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">{{ session('success') }}</div>
                @endif

                @if ($errors->any())
                    <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        <ul class="list-inside list-disc">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <section class="mt-8 grid gap-8 xl:grid-cols-3">

                    <aside class="h-fit rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">

                        <h2 class="text-lg font-semibold">Add a task</h2>

                        <form method="POST" action="{{ route('tasks.store') }}" class="mt-5 space-y-4">
                            @csrf

                            <div>
                                <label class="mb-1.5 block text-sm font-medium" for="title">Title</label>
                                <input class="w-full border border-gray-500 rounded-xl px-3 py-2.5 focus:border-blue-600 focus:ring-blue-600" id="title" name="title" value="{{ old('title') }}" required>
                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium" for="description">Description</label>
                                <textarea class="w-full border border-gray-500 rounded-xl resize-none px-3 py-2.5 focus:border-blue-600 focus:ring-blue-600" id="description" name="description" rows="3">{{ old('description') }}</textarea>
                            </div>

                            <div class="grid grid-cols-2 gap-3">

                                <div>
                                    <label class="mb-1.5 block text-sm font-medium" for="priority">Priority</label>
                                    <select class="w-full rounded-xl border-slate-200 px-3 py-2.5 focus:border-blue-600 focus:ring-blue-600" id="priority" name="priority">
                                        <option value="low">Low</option>
                                        <option value="medium" selected>Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="mb-1.5 block text-sm font-medium" for="due_date">Due date</label>
                                    <input class="w-full rounded-xl border-slate-200 px-3 py-2.5 focus:border-blue-600 focus:ring-blue-600" id="due_date" name="due_date" type="date" value="{{ old('due_date') }}">
                                </div>

                            </div>

                            <div>
                                <label class="mb-1.5 block text-sm font-medium" for="category_id">Category</label>
                                <select class="w-full rounded-xl border-slate-200 px-3 py-2.5 focus:border-blue-600 focus:ring-blue-600" id="category_id" name="category_id">
                                    <option value="">Uncategorized</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="w-full rounded-xl bg-blue-700 px-4 py-3 font-semibold text-white transition hover:bg-blue-800">Create task</button>
                        </form>

                    </aside>

                    <section class="space-y-4 xl:col-span-2">

                        @forelse ($tasks as $task)

                            <details id="task-{{ $task->id }}" class="group rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

                                <summary class="flex cursor-pointer list-none items-center gap-4 p-5">

                                    <span class="h-3 w-3 shrink-0 rounded-full {{ $task->status === 'completed' ? 'bg-emerald-500' : ($task->priority === 'high' ? 'bg-rose-500' : 'bg-blue-500') }}"></span>

                                    <div class="min-w-0 flex-1">
                                        <p class="font-semibold {{ $task->status === 'completed' ? 'text-slate-400 line-through' : '' }}">{{ $task->title }}</p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ ucfirst(str_replace('_', ' ', $task->status)) }} · {{ ucfirst($task->priority) }}
                                            @if ($task->due_date)
                                                · Due {{ $task->due_date->format('M j, Y') }}
                                            @endif
                                        </p>
                                    </div>

                                    <span class="text-sm font-medium text-blue-700">Edit</span>

                                </summary>

                                <div class="border-t border-slate-100 p-5">

                                    <form method="POST" action="{{ route('tasks.update', $task) }}" class="space-y-4">
                                        @csrf
                                        @method('PUT')

                                        <div>
                                            <label class="mb-1.5 block text-sm font-medium">Title</label>
                                            <input class="w-full rounded-xl border border-gray-500  px-3 py-2.5 focus:border-blue-600 focus:ring-blue-600" name="title" value="{{ $task->title }}" required>
                                        </div>

                                        <div>
                                            <label class="mb-1.5 block text-sm font-medium">Description</label>
                                            <textarea class="w-full rounded-xl border border-gray-500 px-3 py-2.5 resize-none focus:border-blue-600 focus:ring-blue-600" name="description" rows="3">{{ $task->description }}</textarea>
                                        </div>

                                        <div class="grid gap-3 sm:grid-cols-2">

                                            <div>
                                                <label class="mb-1.5 block text-sm font-medium">Status</label>
                                                <select class="w-full rounded-xl border-slate-200 px-3 py-2.5" name="status">
                                                    @foreach(['pending' => 'Pending', 'in_progress' => 'In progress', 'completed' => 'Completed'] as $value => $label)
                                                        <option value="{{ $value }}" @selected($task->status === $value)>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div>
                                                <label class="mb-1.5 block text-sm font-medium">Priority</label>
                                                <select class="w-full rounded-xl border-slate-200 px-3 py-2.5" name="priority">
                                                    @foreach(['low' => 'Low', 'medium' => 'Medium', 'high' => 'High'] as $value => $label)
                                                        <option value="{{ $value }}" @selected($task->priority === $value)>{{ $label }}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                        </div>

                                        <div class="grid gap-3 sm:grid-cols-2">
                                            <div>
                                                <label class="mb-1.5 block text-sm font-medium">Due date</label>
                                                <input class="w-full rounded-xl border-slate-200 px-3 py-2.5" name="due_date" type="date" value="{{ $task->due_date?->format('Y-m-d') }}">
                                            </div>

                                            <div>
                                                <label class="mb-1.5 block text-sm font-medium">Category</label>
                                                <select class="w-full rounded-xl border-slate-200 px-3 py-2.5" name="category_id">
                                                    <option value="">Uncategorized</option>
                                                    @foreach ($categories as $category)
                                                        <option value="{{ $category->id }}" @selected($task->category_id === $category->id)>{{ $category->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="flex flex-wrap justify-between gap-3">

                                            <button type="submit" class="rounded-xl bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">Save changes</button>

                                    </form>

                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    type="button"
                                                    data-delete-trigger
                                                    data-delete-title="Delete task?"
                                                    data-delete-message="“{{ $task->title }}” will be permanently deleted. This cannot be undone."
                                                    class="rounded-xl px-4 py-2.5 text-sm font-semibold text-rose-600 hover:bg-rose-50"
                                                >
                                                    Delete task
                                                </button>
                                            </form>

                                        </div>

                                </div>

                            </details>

                        @empty

                            <div class="rounded-2xl bg-white px-6 py-16 text-center shadow-sm ring-1 ring-slate-200">
                                <p class="text-lg font-semibold">Your task list is clear.</p>
                                <p class="mt-2 text-slate-500">Add a task whenever something needs your attention.</p>
                            </div>

                        @endforelse

                        <div class="mt-4">
                            {{ $tasks->links() }}
                        </div>

                    </section>

                </section>

            </div>

        </main>

    </div>

    @include('partials.delete-modal')
</body>
</html>