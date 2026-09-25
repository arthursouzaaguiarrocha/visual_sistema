<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('colaboradores', function (Blueprint $table) {
            $table->id();
            // Vínculo opcional com a tabela de login/usuários do sistema
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->string('nome');
            $table->string('cpf')->nullable()->unique();
            $table->string('cargo')->nullable(); // vendedor, designer, produção, motorista, financeiro...
            $table->string('setor')->nullable();
            $table->decimal('salario', 12, 2)->nullable();
            $table->date('data_admissao')->nullable();
            $table->date('data_demissao')->nullable();
            $table->string('telefone')->nullable();
            $table->string('email')->nullable();
            $table->boolean('ativo')->default(true);
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('colaboradores');
    }
};
