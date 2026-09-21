<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Calendar · Hapsay</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6/index.global.min.js"></script>
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">

    <div class="flex min-h-screen">

        @include('partials.sidebar')

        <main id="mainContent" class="ml-64 min-h-screen flex-1 transition-[margin] duration-300 ease-in-out">

            <div class="mx-auto max-w-7xl px-6 py-10 lg:px-8">

                <div class="flex flex-col gap-3 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.16em] text-blue-700">Planning</p>
                        <h1 class="mt-2 text-3xl font-semibold tracking-tight">Due date calendar</h1>
                    </div>

                    <a href="{{ route('tasks.index') }}" class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">Back to tasks</a>
                </div>

                <section class="mt-8 rounded-2xl bg-white p-4 shadow-sm ring-1 ring-slate-200 sm:p-6">
                    @if($calendarTasks->isNotEmpty())
                        <div id="calendar" data-events='@json($calendarTasks)' style="min-height: 700px;"></div>
                    @else
                        <div class="flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-6 py-12 text-center" style="min-height: 420px;">
                            <div class="mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-blue-100 text-blue-700">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                            </div>
                            <p class="text-xl font-semibold text-slate-800">No tasks with due dates yet</p>
                            <p class="mt-2 max-w-md text-sm text-slate-500">Your calendar will appear here once you add a due date to a task.</p>
                            <a href="{{ route('tasks.index') }}" class="mt-5 inline-flex items-center justify-center rounded-xl bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">Add a task</a>
                        </div>
                    @endif
                </section>

            </div>

            @if($calendarTasks->isNotEmpty())
                <div id="taskModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/65 px-4">
                    <div class="w-full max-w-md rounded-2xl bg-white p-6 shadow-2xl ring-1 ring-slate-200">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-blue-700">Task details</p>
                                <h2 id="taskModalTitle" class="mt-2 text-2xl font-semibold text-slate-900"></h2>
                            </div>
                            <button id="closeTaskModal" type="button" class="rounded-lg p-2 text-slate-500 hover:bg-slate-100 hover:text-slate-900" aria-label="Close task details">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <div class="mt-5 space-y-3 text-sm text-slate-600">
                            <div class="flex items-center justify-between gap-3 rounded-xl bg-slate-50 px-3 py-2">
                                <span class="font-medium text-slate-500">Status</span>
                                <span id="taskModalStatus" class="font-semibold text-slate-800"></span>
                            </div>

                            <div class="flex items-center justify-between gap-3 rounded-xl bg-slate-50 px-3 py-2">
                                <span class="font-medium text-slate-500">Priority</span>
                                <span id="taskModalPriority" class="font-semibold text-slate-800"></span>
                            </div>

                            <div class="flex items-center justify-between gap-3 rounded-xl bg-slate-50 px-3 py-2">
                                <span class="font-medium text-slate-500">Due date</span>
                                <span id="taskModalDate" class="font-semibold text-slate-800"></span>
                            </div>

                            <div class="rounded-xl border border-slate-200 bg-slate-50 p-3">
                                <p class="text-xs font-semibold uppercase tracking-[0.2em] text-slate-500">Description</p>
                                <p id="taskModalDescription" class="mt-2 whitespace-pre-wrap text-slate-700"></p>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-wrap items-center justify-between gap-3">
                            <a id="taskModalLink" href="#" class="inline-flex items-center justify-center rounded-xl bg-blue-700 px-4 py-2.5 text-sm font-semibold text-white hover:bg-blue-800">View task</a>
                            <button id="closeTaskModalButton" type="button" class="rounded-xl border border-slate-200 px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50">Close</button>
                        </div>
                    </div>
                </div>
            @endif

        </main>

    </div>

</body>
</html>