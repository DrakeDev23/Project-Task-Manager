<aside id="sidebar" class="fixed inset-y-0 left-0 z-40 flex w-64 flex-col overflow-hidden border-r border-slate-200 bg-white transition-[width] duration-300 ease-in-out">

    <div class="flex h-20 items-center justify-between border-b border-slate-200 px-5">
        <a href="{{ route('dashboard') }}" id="logo" class="nav-text whitespace-nowrap text-2xl font-bold tracking-tight text-blue-700 transition-all duration-200 ease-in-out">Hapsay</a>
        <button id="sidebarToggle" type="button" class="shrink-0 rounded-lg p-2 text-slate-500 transition-all duration-300 ease-in-out hover:bg-slate-100 hover:text-slate-900">
            <svg id="menuIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 transition-transform duration-300 ease-in-out" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <nav class="flex-1 space-y-1 px-3 py-5">

        @php
            $navItem = function ($route, $label, $svg) {
                $active = request()->routeIs($route) ? 'bg-blue-50 text-blue-700' : 'text-slate-600';
                return '<a href="'.route($route).'" class="nav-item flex items-center gap-3 rounded-xl px-4 py-3 text-sm font-semibold '. $active .' transition-all duration-200 hover:bg-slate-100 hover:text-slate-900">'.$svg.'<span class="nav-text whitespace-nowrap transition-all duration-200 ease-in-out">'.$label.'</span></a>';
            };
        @endphp

        {!! $navItem('dashboard', 'Dashboard', '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M5 10v10h14V10"/></svg>') !!}

        {!! $navItem('tasks.index', 'Tasks', '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 004 0M9 5h6"/></svg>') !!}

        {!! $navItem('calendar', 'Calendar', '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>') !!}

        {!! $navItem('categories.index', 'Categories', '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6.75A2.75 2.75 0 016.75 4h10.5A2.75 2.75 0 0120 6.75v10.5A2.75 2.75 0 0117.25 20H6.75A2.75 2.75 0 014 17.25V6.75zm3.25 1.5h9.5M7.25 12h9.5m-9.5 4h5.5"/></svg>') !!}

        {{-- Account settings icon (user) --}}
        {!! $navItem('settings.account', 'Account settings', '<svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 15c2.5 0 4.847.66 6.879 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>') !!}

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
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                <span class="nav-text whitespace-nowrap transition-all duration-200 ease-in-out">Log out</span>
            </button>
        </form>
    </div>

</aside>
