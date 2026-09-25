<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('materias_primas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fornecedor_id')->nullable()->constrained('fornecedores')->nullOnDelete();
            $table->string('nome'); // ex: lona 440g, vinil adesivo, chapa ACM, tinta eco-solvente
            $table->text('descricao')->nullable();
            $table->string('unidade_medida'); // m, m2, un, kg, rolo, litro
            $table->decimal('quantidade_estoque', 12, 3)->default(0);
            $table->decimal('estoque_minimo', 12, 3)->default(0);
            $table->decimal('preco_custo', 12, 2)->default(0);
            $table->string('localizacao_estoque')->nullable();
            $table->boolean('ativo')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('materias_primas');
    }
};
