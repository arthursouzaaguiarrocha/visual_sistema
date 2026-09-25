<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('abastecimentos_veiculos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('veiculo_id')->constrained('veiculos')->cascadeOnDelete();
            $table->foreignId('colaborador_id')->nullable()->constrained('colaboradores')->nullOnDelete();
            $table->date('data');
            $table->unsignedInteger('km_atual')->nullable();
            $table->decimal('litros', 8, 2)->nullable();
            $table->decimal('valor_litro', 8, 3)->nullable();
            $table->decimal('valor_total', 12, 2);
            $table->string('posto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('abastecimentos_veiculos');
    }
};
