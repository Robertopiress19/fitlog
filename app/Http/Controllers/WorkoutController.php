<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class WorkoutController extends Controller
{
    /** Painel do usuário autenticado. */
    public function index(Request $request)
    {
        $user = $request->user();
        $workouts = $user->workouts()->with('exercises')->orderByDesc('date')->get();

        $stats = [
            'workouts'  => $workouts->count(),
            'exercises' => $workouts->sum(fn ($w) => $w->exercises->count()),
            'volume'    => $workouts->sum(fn ($w) => $w->totalVolume()),
        ];

        $chart = $workouts->sortBy('date')->take(-8)->values()->map(fn ($w) => [
            'label'  => $w->date->format('d/m'),
            'volume' => $w->totalVolume(),
        ]);

        // Recordes apenas dos treinos deste usuário.
        $records = Exercise::query()
            ->whereHas('workout', fn ($q) => $q->where('user_id', $user->id))
            ->whereNotNull('weight')
            ->selectRaw('name, MAX(weight) as max_weight')
            ->groupBy('name')
            ->orderByDesc('max_weight')
            ->limit(6)
            ->get();

        $month = Carbon::now()->startOfMonth();
        $trainedDays = $workouts
            ->filter(fn ($w) => $w->date->isSameMonth($month))
            ->map(fn ($w) => (int) $w->date->format('j'))
            ->unique()
            ->values();

        return view('workouts.index', [
            'workouts'     => $workouts->take(5),
            'stats'        => $stats,
            'chart'        => $chart,
            'records'      => $records,
            'monthLabel'   => ucfirst($month->locale('pt_BR')->isoFormat('MMMM')),
            'daysInMonth'  => $month->daysInMonth,
            'firstWeekday' => (int) $month->copy()->startOfMonth()->dayOfWeek,
            'trainedDays'  => $trainedDays,
        ]);
    }

    public function workouts(Request $request)
    {
        $term = $request->query('q');

        $workouts = $request->user()->workouts()
            ->with('exercises')
            ->when($term, fn ($query) => $query->where('title', 'like', "%{$term}%"))
            ->orderByDesc('date')
            ->get();

        return view('workouts.list', compact('workouts', 'term'));
    }

    public function create()
    {
        return view('workouts.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'date'  => ['required', 'date'],
            'title' => ['required', 'string', 'max:120'],
            'notes' => ['nullable', 'string'],
        ]);

        // Cria já vinculado ao usuário logado.
        $workout = $request->user()->workouts()->create($data);

        return redirect()->route('workouts.show', $workout)->with('status', 'Treino criado!');
    }

    public function show(Request $request, Workout $workout)
    {
        $this->ensureOwner($request, $workout);
        $workout->load('exercises');

        return view('workouts.show', compact('workout'));
    }

    public function edit(Request $request, Workout $workout)
    {
        $this->ensureOwner($request, $workout);

        return view('workouts.edit', compact('workout'));
    }

    public function update(Request $request, Workout $workout)
    {
        $this->ensureOwner($request, $workout);

        $data = $request->validate([
            'date'  => ['required', 'date'],
            'title' => ['required', 'string', 'max:120'],
            'notes' => ['nullable', 'string'],
        ]);

        $workout->update($data);

        return redirect()->route('workouts.show', $workout)->with('status', 'Treino atualizado!');
    }

    public function destroy(Request $request, Workout $workout)
    {
        $this->ensureOwner($request, $workout);
        $workout->delete();

        return redirect()->route('workouts.index')->with('status', 'Treino removido.');
    }

    /** Bloqueia o acesso se o treino não for do usuário autenticado. */
    private function ensureOwner(Request $request, Workout $workout): void
    {
        abort_unless($workout->user_id === $request->user()->id, 403);
    }
}
