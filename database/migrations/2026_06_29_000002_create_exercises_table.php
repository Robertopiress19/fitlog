<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            // Ao apagar um treino, seus exercícios são apagados junto (cascade).
            $table->foreignId('workout_id')->constrained()->cascadeOnDelete();
            $table->string('name');
            $table->unsignedSmallInteger('sets');
            $table->unsignedSmallInteger('reps');
            $table->decimal('weight', 6, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
