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

        @include('partials.sidebar')

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
