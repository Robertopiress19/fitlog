@extends('layouts.app')

@section('content')
    <a href="{{ route('workouts.list') }}" class="mb-4 inline-block text-sm text-slate-500 hover:text-brand-600 dark:text-slate-400">&larr; Voltar</a>

    <div class="mb-6 flex flex-wrap items-start justify-between gap-4">
        <div>
            <h1 class="text-2xl font-bold">{{ $workout->title }}</h1>
            <p class="text-slate-500 dark:text-slate-400">{{ $workout->date->format('d/m/Y') }}</p>
            @if ($workout->notes)
                <p class="mt-2 text-slate-600 dark:text-slate-300">{{ $workout->notes }}</p>
            @endif
        </div>
        <div class="flex items-center gap-2">
            <span class="rounded-lg bg-brand-50 px-3 py-2 text-sm font-semibold text-brand-700 dark:bg-brand-700/60 dark:text-brand-400">
                {{ number_format($workout->totalVolume(), 0, ',', '.') }} kg
            </span>
            <a href="{{ route('workouts.edit', $workout) }}"
               class="rounded-lg border border-slate-300 px-3 py-2 text-sm transition hover:border-brand-500 dark:border-slate-700">Editar</a>
            <form method="POST" action="{{ route('workouts.destroy', $workout) }}"
                  onsubmit="return confirm('Remover este treino?')">
                @csrf @method('DELETE')
                <button class="rounded-lg border border-red-300 px-3 py-2 text-sm text-red-600 transition hover:bg-red-50 dark:border-red-900 dark:hover:bg-red-950/40">Excluir</button>
            </form>
        </div>
    </div>

    <div class="mb-6 overflow-hidden rounded-xl border border-slate-200 bg-white dark:border-slate-800 dark:bg-slate-900">
        <table class="w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-500 dark:bg-slate-800/50 dark:text-slate-400">
                <tr>
                    <th class="px-4 py-3 font-medium">Exercício</th>
                    <th class="px-4 py-3 font-medium">Séries</th>
                    <th class="px-4 py-3 font-medium">Reps</th>
                    <th class="px-4 py-3 font-medium">Carga</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($workout->exercises as $ex)
                    <tr class="border-t border-slate-100 dark:border-slate-800">
                        <td class="px-4 py-3 font-medium">{{ $ex->name }}</td>
                        <td class="px-4 py-3">{{ $ex->sets }}</td>
                        <td class="px-4 py-3">{{ $ex->reps }}</td>
                        <td class="px-4 py-3">{{ $ex->weight ? $ex->weight . ' kg' : '—' }}</td>
                        <td class="px-4 py-3 text-right">
                            <form method="POST" action="{{ route('exercises.destroy', $ex) }}">
                                @csrf @method('DELETE')
                                <button class="text-red-500 transition hover:underline">remover</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="5" class="px-4 py-6 text-center text-slate-400">Nenhum exercício ainda.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="rounded-xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-slate-900">
        <h2 class="mb-4 font-semibold">Adicionar exercício</h2>
        @php($inp = 'w-full rounded-lg border border-slate-300 bg-white px-3 py-2 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100')
        <form method="POST" action="{{ route('workouts.exercises.store', $workout) }}"
              class="grid grid-cols-1 items-end gap-3 sm:grid-cols-5">
            @csrf
            <div class="sm:col-span-2">
                <label class="mb-1 block text-sm">Nome</label>
                <input name="name" class="{{ $inp }}" required>
            </div>
            <div>
                <label class="mb-1 block text-sm">Séries</label>
                <input type="number" name="sets" class="{{ $inp }}" required>
            </div>
            <div>
                <label class="mb-1 block text-sm">Reps</label>
                <input type="number" name="reps" class="{{ $inp }}" required>
            </div>
            <div>
                <label class="mb-1 block text-sm">Carga (kg)</label>
                <input type="number" step="0.5" name="weight" class="{{ $inp }}">
            </div>
            <div class="sm:col-span-5">
                <button class="rounded-lg bg-brand-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-brand-700">
                    Adicionar
                </button>
            </div>
        </form>

        @if ($errors->any())
            <ul class="mt-3 list-disc pl-5 text-sm text-red-500">
                @foreach ($errors->all() as $e) <li>{{ $e }}</li> @endforeach
            </ul>
        @endif
    </div>
@endsection
