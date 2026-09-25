<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fluxo_caixa', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['entrada', 'saida']);
            $table->foreignId('categoria_financeira_id')->nullable()->constrained('categorias_financeiras')->nullOnDelete();
            $table->foreignId('conta_pagar_id')->nullable()->constrained('contas_pagar')->nullOnDelete();
            $table->foreignId('conta_receber_id')->nullable()->constrained('contas_receber')->nullOnDelete();
            $table->foreignId('colaborador_id')->nullable()->constrained('colaboradores')->nullOnDelete(); // quem registrou
            $table->string('descricao');
            $table->decimal('valor', 12, 2);
            $table->date('data_movimento');
            $table->string('forma_pagamento')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fluxo_caixa');
    }
};
