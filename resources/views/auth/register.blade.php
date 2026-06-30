@extends('layouts.guest')

@section('content')
    <h1 class="text-3xl font-extrabold">Crie sua conta</h1>
    <p class="mt-2 text-sm text-slate-500 dark:text-slate-400">Leva menos de um minuto. Comece a registrar seus treinos.</p>

    @php($inp = 'w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm transition focus:border-brand-500 focus:outline-none focus:ring-2 focus:ring-brand-500/30 dark:border-slate-700 dark:bg-slate-900 dark:text-slate-100')

    <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-5">
        @csrf
        <div>
            <label class="mb-1.5 block text-sm font-semibold">Nome</label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="Seu nome" class="{{ $inp }}" required autofocus>
            @error('name') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="mb-1.5 block text-sm font-semibold">E-mail</label>
            <input type="email" name="email" value="{{ old('email') }}" placeholder="voce@email.com" class="{{ $inp }}" required>
            @error('email') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
        </div>
        <div class="grid grid-cols-2 gap-3">
            <div>
                <label class="mb-1.5 block text-sm font-semibold">Senha</label>
                <input type="password" name="password" placeholder="••••••••" class="{{ $inp }}" required>
                @error('password') <p class="mt-1.5 text-sm text-red-500">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="mb-1.5 block text-sm font-semibold">Confirmar</label>
                <input type="password" name="password_confirmation" placeholder="••••••••" class="{{ $inp }}" required>
            </div>
        </div>
        <button class="w-full rounded-xl bg-brand-500 px-4 py-3 font-semibold text-white transition hover:bg-brand-600">Criar conta</button>
    </form>

    <p class="mt-8 text-center text-sm text-slate-500 dark:text-slate-400">
        Já tem conta? <a href="{{ route('login') }}" class="font-semibold text-brand-600 hover:underline dark:text-brand-400">Entrar</a>
    </p>
@endsection
