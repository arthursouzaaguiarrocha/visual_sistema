<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Ficha técnica: quanto de cada matéria-prima o produto consome
        Schema::create('produto_materia_prima', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('produtos')->cascadeOnDelete();
            $table->foreignId('materia_prima_id')->constrained('materias_primas')->cascadeOnDelete();
            $table->decimal('quantidade', 12, 4); // quantidade consumida por unidade do produto
            $table->timestamps();

            $table->unique(['produto_id', 'materia_prima_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produto_materia_prima');
    }
};
