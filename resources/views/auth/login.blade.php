<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Hapsay</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="text-slate-900">
    <main class="grid h-screen w-full lg:grid-cols-2">
        <div class="hidden flex-col justify-between bg-blue-700 p-12 text-white lg:flex">
            <a href="{{ route('login') }}" class="text-2xl font-bold tracking-tight">Hapsay</a>
            <div>
                <h1 class="max-w-md text-5xl font-semibold leading-tight">Make room for what matters</h1>
                <p class="mt-6 max-w-md text-lg leading-8 text-blue-100">Plan your work, stay on top of deadlines, and finish each day with more clarity.</p>
            </div>
            <p class="text-sm text-blue-200">A calmer way to manage your tasks.</p>
        </div>
        <div class="flex items-center justify-center bg-white p-7 sm:p-12">
            <div class="w-full max-w-md">
                <a href="{{ route('login') }}" class="text-2xl font-bold tracking-tight text-blue-700 lg:hidden">Hapsay.</a>
                <h2 class="mt-10 text-3xl font-semibold tracking-tight">Welcome back</h2>
                <p class="mt-2 text-slate-500">Sign in to continue organizing your day.</p>

                @if ($errors->any())
                    <div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                        {{ $errors->first() }}
                    </div>
                @endif
                @if (session('status'))
                    <div class="mt-6 rounded-xl border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">{{ session('status') }}</div>
                @endif

                <a href="{{ route('auth.google') }}" class="mt-7 flex w-full items-center justify-center gap-3 rounded-xl border border-slate-200 px-4 py-3 font-medium transition hover:bg-slate-50">
                    <svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M21.35 12.23c0-.79-.07-1.55-.2-2.28H12v4.32h5.24a4.48 4.48 0 0 1-1.94 2.94v2.45h3.14c1.84-1.69 2.91-4.18 2.91-7.43Z"/><path fill="#34A853" d="M12 21.6c2.63 0 4.84-.87 6.45-2.36l-3.14-2.45c-.87.58-1.98.92-3.31.92-2.54 0-4.69-1.72-5.46-4.03H3.3v2.53A9.75 9.75 0 0 0 12 21.6Z"/><path fill="#FBBC05" d="M6.54 13.68a5.87 5.87 0 0 1 0-3.36V7.79H3.3a9.6 9.6 0 0 0 0 8.42l3.24-2.53Z"/><path fill="#EA4335" d="M12 6.29c1.43 0 2.71.49 3.72 1.46l2.79-2.79C16.83 3.3 14.62 2.4 12 2.4a9.75 9.75 0 0 0-8.7 5.39l3.24 2.53C7.31 8.01 9.46 6.29 12 6.29Z"/></svg>
                    Continue with Google
                </a>
                <div class="my-7 flex items-center gap-4 text-xs text-slate-400"><span class="h-px flex-1 bg-slate-200"></span>OR CONTINUE WITH EMAIL<span class="h-px flex-1 bg-slate-200"></span></div>
                <form method="POST" action="{{ route('login.attempt') }}" class="space-y-5">
                    @csrf
                    <div><label for="email" class="mb-2 block text-sm font-medium">Email address</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus autocomplete="email" class="w-full border rounded-xl border-gray-400 px-4 py-3 focus:border-blue-600 focus:ring-blue-600" placeholder="you@example.com"></div>
                    <div>
                        <label for="password" class="mb-2 block text-sm font-medium">Password</label>
                        <div class="relative">
                            <input id="password" name="password" type="password" required autocomplete="current-password" class="w-full rounded-xl border border-gray-400 px-4 py-3 pr-12 focus:border-blue-600 focus:ring-blue-600" placeholder="Enter your password">
                            <button type="button" data-password-toggle="password" aria-label="Show password" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-600">
                                <svg data-eye-icon class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8Z"></path><circle cx="12" cy="12" r="3"></circle></svg>
                                <svg data-eye-off-icon class="hidden h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17.94 17.94A10.94 10.94 0 0 1 12 20c-7 0-11-8-11-8a20.3 20.3 0 0 1 5.06-6.06M9.9 4.24A10.94 10.94 0 0 1 12 4c7 0 11 8 11 8a20.3 20.3 0 0 1-3.22 4.44M14.12 14.12a3 3 0 1 1-4.24-4.24"></path><path d="M1 1l22 22"></path></svg>
                            </button>
                        </div>
                    </div>
                    <label class="flex items-center gap-2 text-sm text-slate-600"><input type="checkbox" name="remember" value="1" class="rounded border-slate-300 text-blue-600 focus:ring-blue-600"> Remember me</label>
                    <button class="w-full rounded-xl bg-blue-700 px-4 py-3 font-semibold text-white transition hover:bg-blue-800">Sign in</button>
                </form>
                <p class="mt-4 text-center text-sm"><a class="font-semibold text-blue-700 hover:text-blue-800" href="{{ route('password.request') }}">Forgot your password?</a></p>
                <p class="mt-8 text-center text-sm text-slate-500">New to Hapsay? <a href="{{ route('register') }}" class="font-semibold text-blue-700 hover:text-blue-800">Create an account</a></p>
            </div>
        </div>
    </main>
</body>
</html>
