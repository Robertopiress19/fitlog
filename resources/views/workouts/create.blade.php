@extends('layouts.app')

@section('content')
    <a href="{{ route('workouts.list') }}" class="mb-4 inline-block text-sm text-slate-500 hover:text-brand-600 dark:text-slate-400">&larr; Voltar</a>
    <h1 class="mb-6 text-2xl font-bold">Novo treino</h1>

    <form method="POST" action="{{ route('workouts.store') }}"
          class="space-y-4 rounded-xl border border-slate-200 bg-white p-6 dark:border-slate-800 dark:bg-slate-900">
        @csrf
        @include('workouts._form')
        <button class="rounded-lg bg-brand-600 px-5 py-2.5 font-semibold text-white transition hover:bg-brand-700">
            Salvar treino
        </button>
    </form>
@endsection
