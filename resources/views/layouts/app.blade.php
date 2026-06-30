<!doctype html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FitLog — Diário de Treino</title>

    <script>
        (function () {
            try {
                var t = localStorage.getItem('theme');
                if (t !== 'light' && t !== 'dark') {
                    t = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                }
                if (t === 'dark') document.documentElement.classList.add('dark');
            } catch (e) {}
        })();
    </script>

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { brand: {
                50:'#fdf6e9',100:'#fae7c2',400:'#f0a92a',500:'#e8920c',600:'#c5760a',700:'#9a5e06'
            } } } }
        };
    </script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', system-ui, sans-serif; }</style>
</head>
<body class="h-full bg-slate-50 text-slate-900 transition-colors dark:bg-slate-950 dark:text-slate-100">
<div class="mx-auto flex min-h-full max-w-6xl gap-6 px-4 py-6">

    {{-- ===== Menu lateral ===== --}}
    <aside class="sticky top-6 hidden h-fit w-52 shrink-0 rounded-2xl border border-slate-200 bg-white p-4 dark:border-slate-800 dark:bg-slate-900 sm:block">
        <a href="{{ route('workouts.index') }}" class="mb-6 flex items-center gap-2 px-2 text-lg font-bold">
            <span class="grid h-8 w-8 place-items-center rounded-lg bg-brand-500 text-sm text-white">FL</span>
            Fit<span class="-ml-1.5 text-brand-500">Log</span>
        </a>

        @php($nav = [
            ['workouts.index', 'Painel', 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
            ['workouts.list', 'Treinos', 'M4 6h16M4 12h16M4 18h7'],
        ])

        <nav class="flex flex-col gap-1 text-sm">
            @foreach ($nav as [$route, $label, $path])
                @php($active = request()->routeIs($route))
                <a href="{{ route($route) }}"
                   class="flex items-center gap-3 rounded-lg px-3 py-2 transition
                          {{ $active ? 'bg-brand-50 font-medium text-brand-700 dark:bg-brand-500/15 dark:text-brand-400'
                                     : 'text-slate-600 hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800' }}">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $path }}"/></svg>
                    {{ $label }}
                </a>
            @endforeach
            <a href="{{ route('workouts.index') }}#recordes" class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-4.714 2.143L14 21l-2.286-6.857L7 12l4.714-2.143L14 3z"/></svg>
                Recordes
            </a>
            <a href="{{ route('workouts.index') }}#calendario" class="flex items-center gap-3 rounded-lg px-3 py-2 text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Calendário
            </a>
        </nav>

        <div class="mt-6 border-t border-slate-200 pt-4 dark:border-slate-800">
            <button type="button" onclick="toggleTheme()"
                    class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800">
                <svg class="hidden h-4 w-4 dark:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="4"/><path stroke-linecap="round" d="M12 2v2m0 16v2M4.9 4.9l1.4 1.4m11.4 11.4 1.4 1.4M2 12h2m16 0h2M4.9 19.1l1.4-1.4m11.4-11.4 1.4-1.4"/></svg>
                <svg class="h-4 w-4 dark:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z"/></svg>
                <span class="dark:hidden">Tema escuro</span>
                <span class="hidden dark:inline">Tema claro</span>
            </button>

            @auth
                <div class="mt-3 flex items-center gap-3 px-3">
                    <span class="grid h-8 w-8 shrink-0 place-items-center rounded-full bg-brand-100 text-xs font-semibold text-brand-700 dark:bg-brand-500/20 dark:text-brand-400">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </span>
                    <div class="min-w-0">
                        <p class="truncate text-sm font-medium">{{ auth()->user()->name }}</p>
                    </div>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="mt-2">
                    @csrf
                    <button class="flex w-full items-center gap-3 rounded-lg px-3 py-2 text-sm text-slate-600 transition hover:bg-slate-100 dark:text-slate-300 dark:hover:bg-slate-800">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Sair
                    </button>
                </form>
            @endauth
        </div>
    </aside>

    {{-- ===== Conteúdo ===== --}}
    <main class="min-w-0 flex-1">
        @if (session('status'))
            <div class="mb-6 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700 dark:border-emerald-900 dark:bg-emerald-950/50 dark:text-emerald-300">
                {{ session('status') }}
            </div>
        @endif

        @yield('content')
    </main>
</div>

<script>
    function toggleTheme() {
        var html = document.documentElement;
        html.classList.toggle('dark');
        try { localStorage.setItem('theme', html.classList.contains('dark') ? 'dark' : 'light'); } catch (e) {}
    }
</script>
</body>
</html>
