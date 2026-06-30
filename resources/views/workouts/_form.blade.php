@php($inputClass = 'w-full rounded-lg border border-slate-300 bg-white px-3 py-2 text-slate-900 focus:border-brand-500 focus:outline-none focus:ring-1 focus:ring-brand-500 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-100')

<div>
    <label class="mb-1 block text-sm font-medium">Data</label>
    <input type="date" name="date"
           value="{{ old('date', isset($workout) ? $workout->date->format('Y-m-d') : '') }}"
           class="{{ $inputClass }}" required>
    @error('date') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
</div>

<div>
    <label class="mb-1 block text-sm font-medium">Título (foco do treino)</label>
    <input type="text" name="title" placeholder="Ex.: Peito e Tríceps"
           value="{{ old('title', $workout->title ?? '') }}"
           class="{{ $inputClass }}" required>
    @error('title') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
</div>

<div>
    <label class="mb-1 block text-sm font-medium">Observações</label>
    <textarea name="notes" rows="3" class="{{ $inputClass }}">{{ old('notes', $workout->notes ?? '') }}</textarea>
    @error('notes') <p class="mt-1 text-sm text-red-500">{{ $message }}</p> @enderror
</div>
