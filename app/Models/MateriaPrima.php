<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MateriaPrima extends Model
{
    protected $table = 'materias_primas';

    protected $fillable = [
        'fornecedor_id',
        'nome',
        'descricao',
        'unidade_medida',
        'quantidade_estoque',
        'estoque_minimo',
        'preco_custo',
        'localizacao_estoque',
        'ativo',
    ];

    protected $casts = [
        'quantidade_estoque' => 'decimal:3',
        'estoque_minimo' => 'decimal:3',
        'preco_custo' => 'decimal:2',
        'ativo' => 'boolean',
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class);
    }
}
