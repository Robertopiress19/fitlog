<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ExerciseController;
use App\Http\Controllers\WorkoutController;
use Illuminate\Support\Facades\Route;

// ===== Rotas para visitantes (não logados) =====
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ===== Rotas do app (exigem login) =====
Route::middleware('auth')->group(function () {
    Route::get('/', [WorkoutController::class, 'index'])->name('workouts.index');
    Route::get('/treinos', [WorkoutController::class, 'workouts'])->name('workouts.list');
    Route::get('/workouts', fn () => redirect()->route('workouts.list'));

    Route::resource('workouts', WorkoutController::class)->except(['index']);

    Route::post('workouts/{workout}/exercises', [ExerciseController::class, 'store'])
        ->name('workouts.exercises.store');
    Route::delete('exercises/{exercise}', [ExerciseController::class, 'destroy'])
        ->name('exercises.destroy');
});
