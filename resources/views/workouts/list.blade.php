@extends('layouts.app')

@section('content')
    <div class="mb-6 flex flex-wrap items-center justify-between gap-3">
        <h1 class="text-2xl font-bold">Treinos</h1>
        <a href="{{ route('workouts.create') }}"
           class="inline-flex items-center gap-2 rounded-lg bg-brand-500 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-600">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" d="M12 5v14M5 12h14"/></svg>
            Novo treino
        </a>
    </div>

    {{-- Busca --}}
    <form method="GET" action="{{ route('workouts.list') }}" class="mb-6">
        <div class="relative">
            <svg class="pointer-events-none absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" d="M21 21l-4.3-4.3M11 19a8 8 0 100-16 8 8 0 000 16z"/></svg>
            <input type="text" name="q" value="{{ $term }}" placeholder="Buscar por título do treino..."
                   class="w-full rounded-lg border border-slate-300 bg-white py-2.5 pl-10 pr-4 text-sm focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100">
        </div>
    </form>

    @if ($term)
        <p class="mb-4 text-sm text-slate-500 dark:text-slate-400">
            {{ $workouts->count() }} resultado(s) para "<span class="font-medium">{{ $term }}</span>" ·
            <a href="{{ route('workouts.list') }}" class="text-brand-600 hover:underline dark:text-brand-400">limpar</a>
        </p>
    @endif

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
            {{ $term ? 'Nenhum treino encontrado para essa busca.' : 'Nenhum treino ainda.' }}
        </div>
    @endforelse
@endsection
