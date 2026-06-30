<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Usuário de demonstração (a senha é criptografada pelo cast do model).
        $user = User::create([
            'name'     => 'Demo',
            'email'    => 'demo@fitlog.test',
            'password' => 'password',
        ]);

        $peito = $user->workouts()->create([
            'date'  => now()->subDays(2)->toDateString(),
            'title' => 'Peito e Tríceps',
            'notes' => 'Foco em supino.',
        ]);
        $peito->exercises()->createMany([
            ['name' => 'Supino reto',       'sets' => 4, 'reps' => 10, 'weight' => 60],
            ['name' => 'Supino inclinado',  'sets' => 3, 'reps' => 12, 'weight' => 24],
            ['name' => 'Tríceps corda',     'sets' => 3, 'reps' => 15, 'weight' => 25],
        ]);

        $costas = $user->workouts()->create([
            'date'  => now()->toDateString(),
            'title' => 'Costas e Bíceps',
            'notes' => null,
        ]);
        $costas->exercises()->createMany([
            ['name' => 'Puxada frontal',  'sets' => 4, 'reps' => 10, 'weight' => 50],
            ['name' => 'Remada curvada',  'sets' => 4, 'reps' => 10, 'weight' => 40],
            ['name' => 'Rosca direta',    'sets' => 3, 'reps' => 12, 'weight' => 20],
        ]);
    }
}
