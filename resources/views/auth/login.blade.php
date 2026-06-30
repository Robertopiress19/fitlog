@extends('layouts.guest')

@section('content')
    <h1 class="text-3xl font-extrabold">Bem-vindo de volta</h1>
    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Que bom te ver. Acesse seus treinos.</p>

    @php($inp = 'w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100')

    <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-5">
        @csrf
        <div>
            <label class="mb-1.5 block text-sm font-semibold">E-mail</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="voce@email.com" class="{{ $inp }}" required autofocus>
            @error('email') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="mb-1.5 block text-sm font-semibold">Senha</label>
            <input type="password" name="password" placeholder="••••••••" class="{{ $inp }}" required>
        </div>
        <label class="flex items-center gap-2 text-sm text-slate-600 dark:text-slate-400">
            <input type="checkbox" name="remember" class="h-4 w-4 rounded border-slate-300 text-brand-500 focus:ring-brand-500"> Manter conectado
        </label>
        <button class="w-full rounded-xl bg-brand-500 px-4 py-3 font-semibold text-white transition hover:bg-brand-600">Entrar</button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-500 dark:text-slate-400">
        Não tem conta? <a href="{{ route('register') }}" class="font-semibold text-brand-600 hover:underline dark:text-brand-400">Criar conta grátis</a>
    </p>
@endsection
