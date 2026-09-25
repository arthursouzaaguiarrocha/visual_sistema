<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordens_producao_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('ordem_producao_id')->constrained('ordens_producao')->cascadeOnDelete();
            $table->foreignId('orcamento_item_id')->constrained('orcamento_itens')->cascadeOnDelete();
            $table->foreignId('colaborador_id')->nullable()->constrained('colaboradores')->nullOnDelete();
            $table->enum('status', ['pendente', 'em_producao', 'concluido'])->default('pendente');
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordens_producao_itens');
    }
};
