<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orcamento_itens', function (Blueprint $table) {
            $table->id();
            $table->foreignId('orcamento_id')->constrained('orcamentos')->cascadeOnDelete();
            $table->foreignId('produto_id')->nullable()->constrained('produtos')->nullOnDelete();
            $table->string('descricao'); // snapshot do nome/especificação do produto no momento da venda
            $table->decimal('largura', 8, 3)->nullable(); // metros, para cálculo de m2
            $table->decimal('altura', 8, 3)->nullable();
            $table->decimal('quantidade', 12, 3)->default(1);
            $table->decimal('valor_unitario', 12, 2);
            $table->decimal('valor_total', 12, 2);
            $table->text('observacoes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orcamento_itens');
    }
};
