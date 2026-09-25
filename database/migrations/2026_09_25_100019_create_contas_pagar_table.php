<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contas_pagar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fornecedor_id')->nullable()->constrained('fornecedores')->nullOnDelete();
            $table->foreignId('categoria_financeira_id')->nullable()->constrained('categorias_financeiras')->nullOnDelete();
            $table->foreignId('colaborador_id')->nullable()->constrained('colaboradores')->nullOnDelete(); // quem lançou
            $table->string('descricao');
            $table->decimal('valor', 12, 2);
            $table->decimal('valor_pago', 12, 2)->nullable();
            $table->date('data_emissao')->nullable();
            $table->date('data_vencimento');
            $table->date('data_pagamento')->nullable();
            $table->enum('status', ['pendente', 'pago', 'atrasado', 'cancelado'])->default('pendente');
            $table->string('forma_pagamento')->nullable();
            $table->string('numero_documento')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('contas_pagar');
    }
};
