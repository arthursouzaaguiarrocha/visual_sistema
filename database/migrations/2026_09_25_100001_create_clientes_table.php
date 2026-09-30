<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo', ['Pessoa Fisica', 'Pessoa Juridica'])->default('Pessoa Fisica');
            $table->string('nome'); // nome completo ou razão social
            $table->string('nome_fantasia')->nullable();
            $table->string('cpf_cnpj')->nullable()->unique();
            $table->string('rg_ie')->nullable();
            $table->string('email')->nullable();
            $table->string('telefone');
            $table->string('whatsapp')->nullable();
            $table->string('cep')->nullable();
            $table->string('endereco')->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento')->nullable();
            $table->string('bairro')->nullable();
            $table->string('cidade')->nullable();
            $table->string('estado', 2)->nullable();
            $table->text('observacoes')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
