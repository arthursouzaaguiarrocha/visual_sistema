<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('equipamentos', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('tipo')->nullable(); // impressora, plotter de recorte, laser, cnc, prensa térmica...
            $table->string('marca')->nullable();
            $table->string('modelo')->nullable();
            $table->string('numero_serie')->nullable()->unique();
            $table->date('data_aquisicao')->nullable();
            $table->decimal('valor_aquisicao', 12, 2)->nullable();
            $table->enum('status', ['ativo', 'manutencao', 'inativo'])->default('ativo');
            $table->string('localizacao')->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('equipamentos');
    }
};
