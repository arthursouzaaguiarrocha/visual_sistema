<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manutencoes_veiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('veiculo_id')->constrained('veiculos')->cascadeOnDelete();
            $table->enum('tipo', ['preventiva', 'corretiva']);
            $table->date('data');
            $table->unsignedInteger('km_atual')->nullable();
            $table->decimal('custo', 12, 2)->nullable();
            $table->text('descricao')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manutencoes_veiculos');
    }
};
