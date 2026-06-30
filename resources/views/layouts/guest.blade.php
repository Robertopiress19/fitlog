<!doctype html>
<html lang="pt-BR" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>FitLog</title>
    <script>
        (function () {
            try {
                var t = localStorage.getItem('theme');
                if (t !== 'light' && t !== 'dark') t = window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
                if (t === 'dark') document.documentElement.classList.add('dark');
            } catch (e) {}
        })();
    </script>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { darkMode: 'class', theme: { extend: { colors: { brand: {50:'#fdf6e9',100:'#fae7c2',400:'#f0a92a',500:'#e8920c',600:'#c5760a',700:'#9a5e06',800:'#7a4b06'} } } } };</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>body { font-family: 'Inter', system-ui, sans-serif; }</style>
</head>
<body class="h-full bg-white text-slate-900 dark:bg-slate-950 dark:text-slate-100">
<div class="grid min-h-full lg:grid-cols-2">

    {{-- ===== Lado esquerdo: formulário ===== --}}
    <div class="relative flex flex-col justify-center px-6 py-12 sm:px-10 lg:px-16">
        {{-- Botão de tema no canto --}}
        <button type="button" onclick="toggleTheme()" aria-label="Alternar tema"
                class="absolute right-6 top-6 grid h-9 w-9 place-items-center rounded-lg border border-slate-200 text-slate-500 transition hover:border-brand-400 dark:border-slate-700 dark:text-slate-400">
            <svg class="hidden h-4 w-4 dark:block" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="4"/><path stroke-linecap="round" d="M12 2v2m0 16v2M4.9 4.9l1.4 1.4m11.4 11.4 1.4 1.4M2 12h2m16 0h2M4.9 19.1l1.4-1.4m11.4-11.4 1.4-1.4"/></svg>
            <svg class="h-4 w-4 dark:hidden" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M21 12.8A9 9 0 1 1 11.2 3 7 7 0 0 0 21 12.8Z"/></svg>
        </button>

        <div class="mx-auto w-full max-w-sm">
            <div class="mb-10 flex items-center gap-2 text-xl font-bold">
                <span class="grid h-9 w-9 place-items-center rounded-xl bg-brand-500 text-white">FL</span>
                Fit<span class="-ml-2 text-brand-500">Log</span>
            </div>
            @yield('content')
        </div>
    </div>

    {{-- ===== Lado direito: painel da marca (arte original) ===== --}}
    <div class="relative hidden overflow-hidden bg-brand-500 lg:block">
        {{-- textura de pontos --}}
        <div class="absolute inset-0 opacity-20"
             style="background-image: radial-gradient(circle, #fff 1.4px, transparent 1.4px); background-size: 26px 26px;"></div>
        {{-- blocos decorativos --}}
        <div class="absolute -right-16 -top-16 h-72 w-72 rounded-full bg-brand-400/40"></div>
        <div class="absolute -bottom-20 -left-10 h-64 w-64 rounded-full bg-brand-600/40"></div>

        <div class="relative flex h-full flex-col justify-between p-12">
            <p class="max-w-xs text-sm font-medium uppercase tracking-widest text-white/80">FitLog · Diário de treino</p>

            {{-- Ilustração original: halteres + arcos de movimento --}}
            <div class="flex flex-1 items-center justify-center">
                <svg viewBox="0 0 320 320" class="w-72 max-w-full" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <circle cx="160" cy="160" r="150" stroke="#ffffff" stroke-opacity="0.25" stroke-width="2"/>
                    <circle cx="160" cy="160" r="116" stroke="#ffffff" stroke-opacity="0.18" stroke-width="2"/>
                    <path d="M70 160c0-50 40-90 90-90s90 40 90 90" stroke="#ffffff" stroke-opacity="0.5" stroke-width="3" stroke-linecap="round"/>
                    {{-- halter --}}
                    <g transform="rotate(-30 160 160)">
                        <rect x="120" y="150" width="80" height="20" rx="6" fill="#ffffff"/>
                        <rect x="96" y="132" width="22" height="56" rx="8" fill="#7a4b06"/>
                        <rect x="202" y="132" width="22" height="56" rx="8" fill="#7a4b06"/>
                        <rect x="80" y="140" width="16" height="40" rx="7" fill="#9a5e06"/>
                        <rect x="224" y="140" width="16" height="40" rx="7" fill="#9a5e06"/>
                    </g>
                    <circle cx="250" cy="86" r="7" fill="#ffffff" fill-opacity="0.8"/>
                    <circle cx="74" cy="232" r="5" fill="#ffffff" fill-opacity="0.7"/>
                    <circle cx="250" cy="240" r="4" fill="#ffffff" fill-opacity="0.6"/>
                </svg>
            </div>

            <div>
                <h2 class="text-3xl font-extrabold leading-tight text-white">Treine.<br>Registre.<br>Evolua.</h2>
                <p class="mt-3 max-w-xs text-sm text-white/80">Acompanhe cada série, bata seus recordes e veja sua evolução crescer.</p>
            </div>
        </div>
    </div>
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
