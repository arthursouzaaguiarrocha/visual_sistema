<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('veiculos', function (Blueprint $table) {
            $table->id();
            $table->string('placa')->unique();
            $table->string('marca');
            $table->string('modelo');
            $table->year('ano_fabricacao')->nullable();
            $table->year('ano_modelo')->nullable();
            $table->string('tipo')->nullable(); // moto, carro, van, caminhão
            $table->enum('status', ['ativo', 'manutencao', 'inativo'])->default('ativo');
            $table->unsignedInteger('km_atual')->default(0);
            $table->date('data_aquisicao')->nullable();
            $table->decimal('valor_aquisicao', 12, 2)->nullable();
            $table->text('observacoes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('veiculos');
    }
};
