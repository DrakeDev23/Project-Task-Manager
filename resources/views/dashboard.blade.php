<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard · Hapsay</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">

    <div class="flex min-h-screen">

        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col overflow-hidden border-r border-slate-200 bg-white transition-[width] duration-300 ease-in-out">

            <div class="flex h-20 items-center justify-between border-b border-slate-200 px-5">

                <a href="{{ route('dashboard') }}" id="logo" class="nav-text whitespace-nowrap text-2xl font-bold tracking-tight text-blue-700 transition-all duration-200 ease-in-out">
                    Hapsay
                </a>

                <button id="sidebarToggle" type="button" class="shrink-0 rounded-lg p-2 text-slate-500 transition-all duration-300 ease-in-out hover:bg-slate-100 hover:text-slate-900">

                    <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>

                </button>

            </div>

            <nav class="flex-1 space-y-1 px-3 py-5">

                <a href="{{ route('dashboard') }}" class="nav-item flex items-center gap-3 rounded-xl bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-700 transition-all duration-200 hover:bg-blue-100">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10h14V10"/>
                    </svg>

                    <span class="nav-text whitespace-nowrap transition-all duration-200 ease-in-out">
                        Dashboard
                    </span>

                </a>

                <a href="{{ route('tasks.index') }}" class="nav-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-600 transition-all duration-200 hover:bg-slate-100 hover:text-slate-900">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 004 0M9 5h6"/>
                    </svg>

                    <span class="nav-text whitespace-nowrap transition-all duration-200 ease-in-out">
                        Tasks
                    </span>

                </a>

                <a href="{{ route('calendar') }}" class="nav-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-600 transition-all duration-200 hover:bg-slate-100 hover:text-slate-900">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>

                    <span class="nav-text whitespace-nowrap transition-all duration-200 ease-in-out">
                        Calendar
                    </span>

                </a>

                <a href="{{ route('categories.index') }}" class="nav-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-600 transition-all duration-200 hover:bg-slate-100 hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6.75A2.75 2.75 0 016.75 4h10.5A2.75 2.75 0 0120 6.75v10.5A2.75 2.75 0 0117.25 20H6.75A2.75 2.75 0 014 17.25V6.75zm3.25 1.5h9.5M7.25 12h9.5m-9.5 4h5.5"/>
                    </svg>
                    <span class="nav-text whitespace-nowrap transition-all duration-200 ease-in-out">Categories</span>
                </a>

            </nav>

            <div class="border-t border-slate-200 p-4">

                <div class="mb-4 flex items-center gap-3 px-2">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-100 font-semibold text-blue-700">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>

                    <div class="nav-text min-w-0 transition-all duration-200 ease-in-out">

                        <p class="truncate whitespace-nowrap text-sm font-semibold text-slate-900">
                            {{ auth()->user()->name }}
                        </p>

                        <p class="truncate whitespace-nowrap text-xs text-slate-500">
                            {{ auth()->user()->email }}
                        </p>

                    </div>

                </div>

                <form method="POST" action="{{ route('logout') }}">

                    @csrf

                    <button type="submit" class="nav-item flex w-full items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-600 transition-all duration-200 hover:bg-slate-100 hover:text-red-600">

                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                        </svg>

                        <span class="nav-text whitespace-nowrap transition-all duration-200 ease-in-out">
                            Log out
                        </span>

                    </button>

                </form>

            </div>

        </aside>

        <main id="mainContent" class="ml-64 min-h-screen flex-1 transition-[margin] duration-300 ease-in-out">

            <div class="mx-auto max-w-7xl px-6 py-10 lg:px-8">

                <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">

                    <div>

                        <p class="text-sm font-semibold uppercase tracking-[0.16em] text-blue-700">
                            Overview
                        </p>

                        <h1 class="mt-2 text-3xl font-semibold tracking-tight">
                            Good day, {{ strtok(auth()->user()->name, ' ') }}.
                        </h1>

                        <p class="mt-2 text-slate-500">
                            Here is what needs your attention.
                        </p>

                    </div>

                    <div class="flex flex-wrap items-center gap-3">
                        <a href="{{ route('tasks.index') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-700 px-5 py-3 font-semibold text-white transition hover:bg-blue-800">
                            Manage tasks
                        </a>

                        <a href="{{ route('calendar') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 font-semibold text-slate-700 transition hover:bg-slate-50">
                            View calendar
                        </a>
                    </div>

                </div>

                <section class="mt-10 grid gap-5 sm:grid-cols-2 xl:grid-cols-4">

                    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm text-slate-500">All tasks</p>
                        <p class="mt-3 text-3xl font-semibold">{{ $totalTasks }}</p>
                    </div>

                    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm text-slate-500">Pending</p>
                        <p class="mt-3 text-3xl font-semibold text-amber-600">{{ $pendingTasks }}</p>
                    </div>

                    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm text-slate-500">Completed</p>
                        <p class="mt-3 text-3xl font-semibold text-emerald-600">{{ $completedTasks }}</p>
                    </div>

                    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <p class="text-sm text-slate-500">Upcoming</p>
                        <p class="mt-3 text-3xl font-semibold text-blue-700">{{ $upcomingTasks->count() }}</p>
                    </div>

                </section>

                <section class="mt-10 grid gap-8 lg:grid-cols-5">

                    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 lg:col-span-3">

                        <div class="flex items-center justify-between">

                            <h2 class="text-lg font-semibold">
                                Recent tasks
                            </h2>

                            <a href="{{ route('tasks.index') }}" class="text-sm font-semibold text-blue-700 hover:text-blue-800">
                                View all
                            </a>

                        </div>

                        <div class="mt-5 divide-y divide-slate-100">

                            @forelse ($tasks->take(5) as $task)

                                <div class="flex items-start gap-4 py-4">

                                    <span class="mt-1.5 h-2.5 w-2.5 shrink-0 rounded-full {{ $task->status === 'completed' ? 'bg-emerald-500' : ($task->priority === 'high' ? 'bg-rose-500' : 'bg-blue-500') }}"></span>

                                    <div class="min-w-0 flex-1">

                                        <p class="font-medium {{ $task->status === 'completed' ? 'text-slate-400 line-through' : '' }}">
                                            {{ $task->title }}
                                        </p>

                                        <p class="mt-1 text-sm text-slate-500">
                                            {{ str_replace('_', ' ', $task->status) }} · {{ ucfirst($task->priority) }} priority
                                        </p>

                                    </div>

                                    @if ($task->due_date)

                                        <time class="whitespace-nowrap text-sm text-slate-500">
                                            {{ $task->due_date->format('M j') }}
                                        </time>

                                    @endif

                                </div>

                            @empty

                                <div class="py-12 text-center">

                                    <p class="font-medium">
                                        No tasks yet
                                    </p>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Create your first task to get started.
                                    </p>

                                    <a href="{{ route('tasks.index') }}" class="mt-4 inline-block text-sm font-semibold text-blue-700">
                                        Create a task
                                    </a>

                                </div>

                            @endforelse

                        </div>

                    </div>

                    <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200 lg:col-span-2">

                        <h2 class="text-lg font-semibold">
                            Coming up
                        </h2>

                        <div class="mt-5 space-y-4">

                            @forelse ($upcomingTasks->take(5) as $task)

                                <div class="rounded-xl bg-slate-50 p-4">

                                    <p class="font-medium">{{ $task->title }}</p>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Due {{ $task->due_date->format('l, M j') }}
                                    </p>

                                </div>

                            @empty

                                <p class="py-8 text-center text-sm text-slate-500">
                                    Nothing due soon. Nice work.
                                </p>

                            @endforelse

                        </div>

                    </div>

                </section>

            </div>
        </main>
    </div>
</body>
</html>