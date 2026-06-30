<?php

namespace App\Http\Controllers;

use App\Models\Exercise;
use App\Models\Workout;
use Illuminate\Http\Request;

class ExerciseController extends Controller
{
    public function store(Request $request, Workout $workout)
    {
        abort_unless($workout->user_id === $request->user()->id, 403);

        $data = $request->validate([
            'name'   => ['required', 'string', 'max:120'],
            'sets'   => ['required', 'integer', 'min:1', 'max:50'],
            'reps'   => ['required', 'integer', 'min:1', 'max:500'],
            'weight' => ['nullable', 'numeric', 'min:0'],
        ]);

        $workout->exercises()->create($data);

        return redirect()->route('workouts.show', $workout)->with('status', 'Exercício adicionado!');
    }

    public function destroy(Request $request, Exercise $exercise)
    {
        $workout = $exercise->workout;
        abort_unless($workout->user_id === $request->user()->id, 403);

        $exercise->delete();

        return redirect()->route('workouts.show', $workout)->with('status', 'Exercício removido.');
    }
}
