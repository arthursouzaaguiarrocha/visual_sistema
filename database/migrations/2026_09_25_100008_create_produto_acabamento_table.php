<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Acabamentos padrão vinculados a um produto (podem ser sobrescritos no item do orçamento)
        Schema::create('produto_acabamento', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produto_id')->constrained('produtos')->cascadeOnDelete();
            $table->foreignId('acabamento_id')->constrained('acabamentos')->cascadeOnDelete();
            $table->timestamps();

            $table->unique(['produto_id', 'acabamento_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produto_acabamento');
    }
};
