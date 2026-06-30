@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold">Painel</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400">Acompanhe sua evolução nos treinos.</p>
        </div>
        <a href="{{ route('workouts.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 5v14M5 12h14"/></svg>
            Novo treino
        </a>
    </div>

    {{-- Estatísticas --}}
    <div class="mb-5 grid grid-cols-3 gap-4">
        <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Treinos</p>
            <p class="mt-1 text-3xl font-bold">{{ $stats['workouts'] }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Exercícios</p>
            <p class="mt-1 text-3xl font-bold">{{ $stats['exercises'] }}</p>
        </div>
        <div class="rounded-xl border border-slate-200 bg-white p-5 dark:border-slate-800 dark:bg-slate-900">
            <p class="text-xs font-medium uppercase tracking-wide text-slate-400">Volume total</p>
            <p class="mt-1 text-3xl font-bold">{{ number_format($stats['volume'], 0, ',', '.') }}<span class="text-base font-medium text-slate-400"> kg</span></p>
        </div>
    </div>

    {{-- Gráfico de evolução --}}
    <div class="mb-5 rounded-xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-slate-900">
        <h2 class="mb-4 text-sm font-semibold uppercase tracking-wide text-slate-400">Evolução de volume</h2>
        @if ($chart->count() > 1)
            <div class="relative h-48 w-full">
                <canvas id="volChart"></canvas>
            </div>
        @else
            <p class="py-8 text-center text-sm text-slate-400">Registre mais treinos para ver sua evolução.</p>
        @endif
    </div>

    <div class="mb-5 grid grid-cols-1 gap-5 lg:grid-cols-2">
        {{-- Calendário --}}
        <div id="calendario" class="rounded-xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-slate-900">
            <h2 class="mb-4 text-sm font-semibold uppercase tracking-wide text-slate-400">{{ $monthLabel }}</h2>
            <div class="grid grid-cols-7 gap-1.5 text-center text-xs text-slate-400">
                @foreach (['D','S','T','Q','Q','S','S'] as $d) <span>{{ $d }}</span> @endforeach
            </div>
            <div class="mt-1.5 grid grid-cols-7 gap-1.5 text-center text-xs">
                @for ($i = 0; $i < $firstWeekday; $i++) <span></span> @endfor
                @for ($day = 1; $day <= $daysInMonth; $day++)
                    @php($trained = $trainedDays->contains($day))
                    <span class="rounded-md py-1.5 {{ $trained ? 'bg-brand-100 font-semibold text-brand-700 dark:bg-brand-500/20 dark:text-brand-400' : 'text-slate-400' }}">
                        {{ $day }}
                    </span>
                @endfor
            </div>
            <div class="mt-4 flex items-center gap-2 text-xs text-slate-400">
                <span class="inline-block h-2.5 w-2.5 rounded-full bg-brand-500"></span> dia treinado
            </div>
        </div>

        {{-- Recordes --}}
        <div id="recordes" class="rounded-xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-slate-900">
            <h2 class="mb-4 text-sm font-semibold uppercase tracking-wide text-slate-400">Recordes pessoais</h2>
            @forelse ($records as $r)
                <div class="flex items-center justify-between border-b border-slate-100 py-2.5 text-sm last:border-0 dark:border-slate-800">
                    <span class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-brand-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-4.714 2.143L14 21l-2.286-6.857L7 12l4.714-2.143L14 3z"/></svg>
                        {{ $r->name }}
                    </span>
                    <span class="font-semibold">{{ rtrim(rtrim(number_format($r->max_weight, 2, ',', '.'), '0'), ',') }} kg</span>
                </div>
            @empty
                <p class="py-6 text-center text-sm text-slate-400">Registre exercícios com carga para ver seus recordes.</p>
            @endforelse
        </div>
    </div>

    {{-- Treinos recentes --}}
    <div class="mb-3 flex items-center justify-between">
        <h2 class="text-sm font-semibold uppercase tracking-wide text-slate-400">Treinos recentes</h2>
        <a href="{{ route('workouts.list') }}" class="text-sm font-medium text-brand-600 hover:underline dark:text-brand-400">Ver todos &rarr;</a>
    </div>
    @forelse ($workouts as $workout)
        <a href="{{ route('workouts.show', $workout) }}"
           class="group mb-3 block rounded-xl border border-slate-200 bg-white p-5 transition hover:border-brand-400 dark:border-slate-800 dark:bg-slate-900 dark:hover:border-brand-500">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-semibold">{{ $workout->title }}</h3>
                    <p class="text-sm text-slate-500 dark:text-slate-400">
                        {{ $workout->date->format('d/m/Y') }} · {{ $workout->exercises->count() }} exercícios · {{ number_format($workout->totalVolume(), 0, ',', '.') }} kg
                    </p>
                </div>
                <span class="text-sm font-medium text-brand-600 transition group-hover:translate-x-0.5 dark:text-brand-400">Ver &rarr;</span>
            </div>
        </a>
    @empty
        <div class="rounded-xl border border-dashed border-slate-300 p-10 text-center text-slate-400 dark:border-slate-700">
            Nenhum treino ainda. Clique em "Novo treino" para começar.
        </div>
    @endforelse

    @if ($chart->count() > 1)
        <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
        <script>
            (function () {
                var ctx = document.getElementById('volChart');
                if (!ctx || !window.Chart) return;
                var dark = document.documentElement.classList.contains('dark');
                new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: @json($chart->pluck('label')),
                        datasets: [{
                            data: @json($chart->pluck('volume')),
                            borderColor: '#e8920c',
                            borderWidth: 2,
                            tension: 0.35,
                            pointRadius: 3,
                            pointBackgroundColor: '#e8920c',
                            fill: true,
                            backgroundColor: 'rgba(232,146,12,0.12)'
                        }]
                    },
                    options: {
                        responsive: true, maintainAspectRatio: false,
                        plugins: { legend: { display: false } },
                        scales: {
                            y: { ticks: { color: '#94a3b8', callback: function (v) { return (v/1000) + 'k'; } },
                                 grid: { color: dark ? 'rgba(148,163,184,0.12)' : 'rgba(148,163,184,0.18)' } },
                            x: { ticks: { color: '#94a3b8' }, grid: { display: false } }
                        }
                    }
                });
            })();
        </script>
    @endif
@endsection
