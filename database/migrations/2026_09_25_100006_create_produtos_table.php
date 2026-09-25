<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('categoria')->nullable(); // banner, adesivo, placa, fachada, lona, papelaria, brinde...
            $table->text('descricao')->nullable();
            $table->string('unidade_medida'); // m2, un, ml
            $table->decimal('preco_base', 12, 2)->default(0);
            $table->decimal('margem_lucro', 5, 2)->nullable(); // percentual
            $table->decimal('tempo_producao_estimado_horas', 8, 2)->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produtos');
    }
};
