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

        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col overflow-hidden border-r border-slate-200 bg-white transition-[width] duration-300 ease-in-out">

            <div class="flex h-20 items-center justify-between border-b border-slate-200 px-5">
                <a href="{{ route('dashboard') }}" class="nav-text whitespace-nowrap text-2xl font-bold tracking-tight text-blue-700 transition-all duration-200 ease-in-out">Hapsay.</a>
                <button id="sidebarToggle" type="button" class="shrink-0 rounded-lg p-2 text-slate-500 transition-all duration-300 ease-in-out hover:bg-slate-100 hover:text-slate-900">
                    <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>

            <nav class="flex-1 space-y-1 px-3 py-5">

                <a href="{{ route('dashboard') }}" class="nav-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-600 transition-all duration-200 hover:bg-slate-100 hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10h14V10"/>
                    </svg>
                    <span class="nav-text whitespace-nowrap transition-all duration-200 ease-in-out">Dashboard</span>
                </a>

                <a href="{{ route('tasks.index') }}" class="nav-item flex items-center gap-3 rounded-xl bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-700 transition-all duration-200 hover:bg-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 004 0M9 5h6"/>
                    </svg>
                    <span class="nav-text whitespace-nowrap transition-all duration-200 ease-in-out">Tasks</span>
                </a>

            </nav>

            <div class="border-t border-slate-200 p-4">

                <div class="mb-4 flex items-center gap-3 px-2">
                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-100 font-semibold text-blue-700">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>

                    <div class="nav-text min-w-0 transition-all duration-200 ease-in-out">
                        <p class="truncate whitespace-nowrap text-sm font-semibold text-slate-900">{{ auth()->user()->name }}</p>
                        <p class="truncate whitespace-nowrap text-xs text-slate-500">{{ auth()->user()->email }}</p>
                    </div>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="nav-item flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-600 transition-all duration-200 hover:bg-slate-100 hover:text-red-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>
                        <span class="nav-text whitespace-nowrap transition-all duration-200 ease-in-out">Log out</span>
                    </button>
                </form>

            </div>

        </aside>

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

                            <button type="submit" class="w-full rounded-xl bg-blue-700 px-4 py-3 font-semibold text-white transition hover:bg-blue-800">Create task</button>
                        </form>

                    </aside>

                    <section class="space-y-4 xl:col-span-2">

                        @forelse ($tasks as $task)

                            <details class="group rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">

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

                                        <div class="grid gap-3 sm:grid-cols-3">

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

                                            <div>
                                                <label class="mb-1.5 block text-sm font-medium">Due date</label>
                                                <input class="w-full rounded-xl border-slate-200 px-3 py-2.5" name="due_date" type="date" value="{{ $task->due_date?->format('Y-m-d') }}">
                                            </div>

                                        </div>

                                        <div class="flex flex-wrap justify-between gap-3">

                                            <button type="submit" class="rounded-xl bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">Save changes</button>

                                    </form>

                                            <form method="POST" action="{{ route('tasks.destroy', $task) }}">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="rounded-xl px-4 py-2.5 text-sm font-semibold text-rose-600 hover:bg-rose-50">Delete task</button>
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

                    </section>

                </section>

            </div>

        </main>

    </div>

</body>
</html>