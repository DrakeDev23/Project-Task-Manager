<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Categories · Hapsay</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">

    <div class="flex min-h-screen">

        <aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col overflow-hidden border-r border-slate-200 bg-white transition-[width] duration-300 ease-in-out">

            <div class="flex h-20 items-center justify-between border-b border-slate-200 px-5">
                <a href="{{ route('dashboard') }}" class="nav-text whitespace-nowrap text-2xl font-bold tracking-tight text-blue-700 transition-all duration-200 ease-in-out">Hapsay</a>
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

                <a href="{{ route('tasks.index') }}" class="nav-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-600 transition-all duration-200 hover:bg-slate-100 hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 004 0M9 5h6"/>
                    </svg>
                    <span class="nav-text whitespace-nowrap transition-all duration-200 ease-in-out">Tasks</span>
                </a>

                <a href="{{ route('calendar') }}" class="nav-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold text-slate-600 transition-all duration-200 hover:bg-slate-100 hover:text-slate-900">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="nav-text whitespace-nowrap transition-all duration-200 ease-in-out">Calendar</span>
                </a>

                <a href="{{ route('categories.index') }}" class="nav-item flex items-center gap-3 rounded-xl bg-blue-50 px-4 py-3 text-sm font-semibold text-blue-700 transition-all duration-200 hover:bg-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6.75A2.75 2.75 0 016.75 4h10.5A2.75 2.75 0 0120 6.75v10.5A2.75 2.75 0 0117.25 20H6.75A2.75 2.75 0 014 17.25V6.75zm3.25 1.5h9.5M7.25 12h9.5m-9.5 4h5.5"/>
                    </svg>
                    <span class="nav-text whitespace-nowrap transition-all duration-200 ease-in-out">Categories</span>
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

                <div class="flex flex-col gap-5 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-sm font-semibold uppercase tracking-[0.16em] text-blue-700">Organization</p>
                        <h1 class="mt-2 text-3xl font-semibold tracking-tight">Categories</h1>
                        <p class="mt-2 text-slate-500">Organize your tasks into categories.</p>
                    </div>

                    @if (! ($editingCategory ?? false))
                        <a href="{{ route('categories.create') }}" class="inline-flex items-center justify-center rounded-xl bg-blue-700 px-5 py-3 font-semibold text-white transition hover:bg-blue-800">
                            Create Category
                        </a>
                    @endif
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

                <div class="mt-8 grid gap-8 lg:grid-cols-[420px_minmax(0,1fr)]">

                    <aside class="h-fit rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
                        <h2 class="text-lg font-semibold">{{ $editingCategory ? 'Edit category' : 'Create category' }}</h2>

                        <form method="POST" action="{{ $editingCategory ? route('categories.update', $editingCategory) : route('categories.store') }}" class="mt-5 space-y-4">
                            @csrf
                            @if ($editingCategory)
                                @method('PUT')
                            @endif

                            <div>
                                <label for="name" class="mb-1.5 block text-sm font-medium text-slate-700">Category name</label>
                                <input id="name" name="name" value="{{ old('name', $editingCategory->name ?? '') }}" class="w-full rounded-xl border border-slate-200 px-3 py-2.5 focus:border-blue-600 focus:ring-blue-600" required>
                            </div>

                            <div>
                                <label for="description" class="mb-1.5 block text-sm font-medium text-slate-700">Description</label>
                                <textarea id="description" name="description" rows="4" class="w-full rounded-xl border resize-none border-slate-200 px-3 py-2.5 focus:border-blue-600 focus:ring-blue-600" placeholder="Optional description for this category">{{ old('description', $editingCategory->description ?? '') }}</textarea>
                            </div>

                            <div class="flex flex-wrap gap-3">
                                <button type="submit" class="rounded-xl bg-blue-700 px-4 py-2.5 font-semibold text-white transition hover:bg-blue-800">
                                    {{ $editingCategory ? 'Save changes' : 'Save category' }}
                                </button>

                                <a href="{{ route('categories.index') }}" class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 font-semibold text-slate-700 transition hover:bg-slate-50">
                                    Cancel
                                </a>
                            </div>
                        </form>
                    </aside>

                    <section class="space-y-4">
                        @forelse ($categories as $category)
                            <article class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                                <div class="flex flex-col gap-4 sm:flex-row sm:items-start sm:justify-between">
                                    <div class="min-w-0 flex-1">
                                        <div class="flex items-center gap-3">
                                            <h3 class="text-lg font-semibold text-slate-900">{{ $category->name }}</h3>
                                            <span class="rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                                                {{ $category->tasks_count }} task{{ $category->tasks_count === 1 ? '' : 's' }}
                                            </span>
                                        </div>

                                        @if ($category->description)
                                            <p class="mt-2 text-sm leading-6 text-slate-600">{{ $category->description }}</p>
                                        @else
                                            <p class="mt-2 text-sm text-slate-400">No description provided.</p>
                                        @endif
                                    </div>

                                    <div class="flex items-center gap-2">
                                        <a href="{{ route('categories.edit', $category) }}" class="rounded-xl border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                            Edit
                                        </a>

                                        <form method="POST" action="{{ route('categories.destroy', $category) }}" onsubmit="return confirm('Delete this category and remove it from your tasks?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="rounded-xl border border-rose-200 bg-rose-50 px-3 py-2 text-sm font-semibold text-rose-600 transition hover:bg-rose-100">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <div class="rounded-2xl bg-white px-6 py-16 text-center shadow-sm ring-1 ring-slate-200">
                                <p class="text-lg font-semibold text-slate-800">No categories yet</p>
                                <p class="mt-2 text-sm text-slate-500">Create a category to organize your tasks and stay focused.</p>
                            </div>
                        @endforelse
                    </section>

                </div>
            </div>
        </main>
    </div>
</body>
</html>
