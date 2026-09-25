<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ordens_producao', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orcamento_id')->constrained('orcamentos')->restrictOnDelete();
            $table->string('numero')->unique(); // ex: OP-2026-0001
            $table->foreignId('colaborador_responsavel_id')->nullable()->constrained('colaboradores')->nullOnDelete();
            $table->foreignId('equipamento_id')->nullable()->constrained('equipamentos')->nullOnDelete();
            $table->enum('status', ['fila', 'em_producao', 'acabamento', 'finalizado', 'entregue', 'cancelado'])->default('fila');
            $table->enum('prioridade', ['baixa', 'normal', 'alta', 'urgente'])->default('normal');
            $table->date('data_inicio_prevista')->nullable();
            $table->date('data_entrega_prevista')->nullable();
            $table->dateTime('data_inicio_real')->nullable();
            $table->dateTime('data_conclusao_real')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ordens_producao');
    }
};
