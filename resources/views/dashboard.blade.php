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

        @include('partials.sidebar')

        <main id="mainContent" class="ml-64 min-h-screen flex-1 transition-[margin] duration-300 ease-in-out">

            <div class="mx-auto max-w-7xl px-6 py-10 lg:px-8">

                <div>
                    <p class="text-sm font-semibold uppercase tracking-[0.16em] text-blue-700">Dashboard</p>
                    <h1 class="mt-2 text-3xl font-semibold tracking-tight text-slate-900">Dashboard</h1>
                    <p class="mt-2 text-slate-500">A quick overview of your tasks and what needs your attention.</p>
                </div>

                @if (session('success'))
                    <div class="mt-6 flex items-center gap-2 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-medium text-emerald-700">
                        <svg class="h-4 w-4 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                <section class="mt-8">
                    <div class="grid gap-6 lg:grid-cols-4">
                        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                            <p class="text-sm font-medium text-slate-500">Total</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $totalTasks }}</p>
                        </div>

                        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                            <p class="text-sm font-medium text-slate-500">In Progress</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $inProgress }}</p>
                        </div>

                        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                            <p class="text-sm font-medium text-slate-500">Completed</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $completedTasks }}</p>
                        </div>

                        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                            <p class="text-sm font-medium text-slate-500">Overdue</p>
                            <p class="mt-2 text-2xl font-semibold text-slate-900">{{ $overdue }}</p>
                        </div>
                    </div>

                    <div class="mt-8 grid gap-6 lg:grid-cols-2">

                        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                            <div class="flex items-start justify-between">
                                <div>
                                    <h2 class="text-lg font-semibold text-slate-900">Recent Tasks</h2>
                                    <p class="mt-1 text-sm text-slate-500">A quick list of your most recent tasks.</p>
                                </div>
                                <a href="{{ route('tasks.index') }}" class="text-sm font-medium text-blue-700">View all tasks</a>
                            </div>

                            <div class="mt-4 space-y-3">
                                @forelse($recentTasks as $task)
                                    <div class="flex items-center justify-between gap-4 rounded-xl bg-slate-50 px-4 py-3">
                                        <div class="min-w-0">
                                            <p class="truncate font-semibold {{ $task->status === 'completed' ? 'text-slate-400 line-through' : 'text-slate-900' }}">{{ $task->title }}</p>
                                            <p class="mt-1 text-sm text-slate-500">{{ ucfirst(str_replace('_',' ', $task->status)) }} · {{ ucfirst($task->priority) }}@if($task->due_date) · Due {{ $task->due_date->format('M j') }}@endif</p>
                                        </div>
                                    </div>
                                @empty
                                    <p class="py-6 text-center text-sm text-slate-500">No recent tasks.</p>
                                @endforelse
                            </div>
                        </div>

                        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                            <h2 class="text-lg font-semibold text-slate-900">Upcoming Tasks</h2>
                            <p class="mt-1 text-sm text-slate-500">Your next deadlines at a glance.</p>

                            <div class="mt-4 space-y-2">
                                @forelse($upcomingTasks as $task)
                                    <div class="flex items-center justify-between gap-4 rounded-xl bg-slate-50 px-4 py-3">
                                        <p class="min-w-0 truncate">{{ $task->title }}</p>
                                        <p class="shrink-0 text-sm text-slate-500">{{ $task->due_date->format('M j') }}</p>
                                    </div>
                                @empty
                                    <p class="py-6 text-center text-sm text-slate-500">Nothing due soon. Nice work.</p>
                                @endforelse
                            </div>
                        </div>

                    </div>

                    <div class="mt-8 rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900">Task Progress</h3>
                        <p class="mt-1 text-sm text-slate-500">Overview of task statuses.</p>

                        <div class="mt-4 space-y-3">
                            @php
                                $totalForBars = max($totalTasks, 1);
                                $inProgressPct = intval(($inProgress / $totalForBars) * 100);
                                $completedPct = intval(($completedTasks / $totalForBars) * 100);
                                $pendingPct = intval(($pendingTasks / $totalForBars) * 100);
                                $overduePct = intval(($overdue / $totalForBars) * 100);
                            @endphp

                            <div>
                                <div class="flex items-center justify-between text-sm text-slate-700">
                                    <span>In Progress</span>
                                    <span>{{ $inProgress }}</span>
                                </div>
                                <div class="mt-2 h-2 w-full rounded-full bg-slate-100">
                                    <div class="h-2 rounded-full bg-blue-600" style="width: {{ $inProgressPct }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between text-sm text-slate-700">
                                    <span>Completed</span>
                                    <span>{{ $completedTasks }}</span>
                                </div>
                                <div class="mt-2 h-2 w-full rounded-full bg-slate-100">
                                    <div class="h-2 rounded-full bg-emerald-500" style="width: {{ $completedPct }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between text-sm text-slate-700">
                                    <span>Pending</span>
                                    <span>{{ $pendingTasks }}</span>
                                </div>
                                <div class="mt-2 h-2 w-full rounded-full bg-slate-100">
                                    <div class="h-2 rounded-full bg-amber-500" style="width: {{ $pendingPct }}%"></div>
                                </div>
                            </div>

                            <div>
                                <div class="flex items-center justify-between text-sm text-slate-700">
                                    <span>Overdue</span>
                                    <span>{{ $overdue }}</span>
                                </div>
                                <div class="mt-2 h-2 w-full rounded-full bg-slate-100">
                                    <div class="h-2 rounded-full bg-rose-500" style="width: {{ $overduePct }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                </section>

            </div>

        </main>

    </div>

</body>
</html>