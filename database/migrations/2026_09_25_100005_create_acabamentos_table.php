<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('acabamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome'); // ilhós, laminação, solda, moldura, corte especial...
            $table->text('descricao')->nullable();
            $table->string('unidade_medida')->nullable(); // un, m, m2
            $table->decimal('preco', 12, 2)->default(0);
            $table->boolean('ativo')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('acabamentos');
    }
};
