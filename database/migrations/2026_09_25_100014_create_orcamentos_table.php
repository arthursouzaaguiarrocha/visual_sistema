<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orcamentos', function (Blueprint $table) {
            $table->id();
            $table->string('numero')->unique(); // ex: ORC-2026-0001
            $table->foreignId('cliente_id')->constrained('clientes')->restrictOnDelete();
            $table->foreignId('colaborador_id')->nullable()->constrained('colaboradores')->nullOnDelete(); // vendedor responsável
            $table->date('data_orcamento');
            $table->date('data_validade')->nullable();
            $table->enum('status', ['pendente', 'aprovado', 'reprovado', 'expirado', 'cancelado'])->default('pendente');
            $table->decimal('valor_desconto', 12, 2)->default(0);
            $table->decimal('valor_frete', 12, 2)->default(0);
            $table->decimal('valor_total', 12, 2)->default(0);
            $table->string('forma_pagamento')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orcamentos');
    }
};
