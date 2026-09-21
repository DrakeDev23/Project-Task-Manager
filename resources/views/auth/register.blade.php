<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Create account · Hapsay</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900">
    <main class="mx-auto flex min-h-screen max-w-7xl items-center p-6 lg:p-10">
        <section class="grid w-full overflow-hidden rounded-3xl bg-white shadow-2xl shadow-blue-950/10 lg:grid-cols-2">
            <div class="hidden min-h-[720px] flex-col justify-between bg-blue-700 p-12 text-white lg:flex">
                <a href="{{ route('login') }}" class="text-2xl font-bold tracking-tight">Hapsay</a>
                <div><p class="mb-4 text-sm font-semibold uppercase tracking-[0.2em] text-blue-200">Start simply</p><h1 class="max-w-md text-5xl font-semibold leading-tight">Your day, beautifully organized.</h1><p class="mt-6 max-w-md text-lg leading-8 text-blue-100">Capture every task and bring focus back to your work.</p></div>
                <p class="text-sm text-blue-200">One list. More progress.</p>
            </div>
            <div class="flex min-h-[720px] items-center justify-center p-7 sm:p-12"><div class="w-full max-w-md">
                <a href="{{ route('login') }}" class="text-2xl font-bold tracking-tight text-blue-700 lg:hidden">Hapsay.</a>
                <h1 class="mt-10 text-3xl font-semibold tracking-tight">Create your account</h1><p class="mt-2 text-slate-500">Start planning with a free personal workspace.</p>
                @if ($errors->any())<div class="mt-6 rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700"><ul class="list-inside list-disc">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>@endif
                <a href="{{ route('auth.google') }}" class="mt-7 flex w-full items-center justify-center gap-3 rounded-xl border border-slate-200 px-4 py-3 font-medium transition hover:bg-slate-50"><svg class="h-5 w-5" viewBox="0 0 24 24" aria-hidden="true"><path fill="#4285F4" d="M21.35 12.23c0-.79-.07-1.55-.2-2.28H12v4.32h5.24a4.48 4.48 0 0 1-1.94 2.94v2.45h3.14c1.84-1.69 2.91-4.18 2.91-7.43Z"/><path fill="#34A853" d="M12 21.6c2.63 0 4.84-.87 6.45-2.36l-3.14-2.45c-.87.58-1.98.92-3.31.92-2.54 0-4.69-1.72-5.46-4.03H3.3v2.53A9.75 9.75 0 0 0 12 21.6Z"/><path fill="#FBBC05" d="M6.54 13.68a5.87 5.87 0 0 1 0-3.36V7.79H3.3a9.6 9.6 0 0 0 0 8.42l3.24-2.53Z"/><path fill="#EA4335" d="M12 6.29c1.43 0 2.71.49 3.72 1.46l2.79-2.79C16.83 3.3 14.62 2.4 12 2.4a9.75 9.75 0 0 0-8.7 5.39l3.24 2.53C7.31 8.01 9.46 6.29 12 6.29Z"/></svg>Continue with Google</a>
                <div class="my-7 flex items-center gap-4 text-xs text-slate-400"><span class="h-px flex-1 bg-slate-200"></span>OR REGISTER WITH EMAIL<span class="h-px flex-1 bg-slate-200"></span></div>
                <form method="POST" action="{{ route('register.store') }}" class="space-y-4">@csrf
                    <div><label for="name" class="mb-2 block text-sm font-medium">Name</label><input id="name" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" class="w-full rounded-xl border-slate-200 px-4 py-3 focus:border-blue-600 focus:ring-blue-600" placeholder="Your name"></div>
                    <div><label for="email" class="mb-2 block text-sm font-medium">Email address</label><input id="email" name="email" type="email" value="{{ old('email') }}" required autocomplete="email" class="w-full rounded-xl border-slate-200 px-4 py-3 focus:border-blue-600 focus:ring-blue-600" placeholder="you@example.com"></div>
                    <div><label for="password" class="mb-2 block text-sm font-medium">Password</label><input id="password" name="password" type="password" required autocomplete="new-password" class="w-full rounded-xl border-slate-200 px-4 py-3 focus:border-blue-600 focus:ring-blue-600" placeholder="At least 8 characters"></div>
                    <div><label for="password_confirmation" class="mb-2 block text-sm font-medium">Confirm password</label><input id="password_confirmation" name="password_confirmation" type="password" required autocomplete="new-password" class="w-full rounded-xl border-slate-200 px-4 py-3 focus:border-blue-600 focus:ring-blue-600" placeholder="Repeat your password"></div>
                    <button class="w-full rounded-xl bg-blue-700 px-4 py-3 font-semibold text-white transition hover:bg-blue-800">Create account</button>
                </form>
                <p class="mt-7 text-center text-sm text-slate-500">Already have an account? <a href="{{ route('login') }}" class="font-semibold text-blue-700 hover:text-blue-800">Sign in</a></p>
            </div></div>
        </section>
    </main>
</body>
</html>
