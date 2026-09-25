<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manutencoes_equipamentos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('equipamento_id')->constrained('equipamentos')->cascadeOnDelete();
            $table->enum('tipo', ['preventiva', 'corretiva']);
            $table->date('data');
            $table->decimal('custo', 12, 2)->nullable();
            $table->text('descricao')->nullable();
            $table->string('responsavel')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manutencoes_equipamentos');
    }
};
