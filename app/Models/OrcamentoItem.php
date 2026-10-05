<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrcamentoItem extends Model
{
    protected $table = 'orcamento_itens';

    protected $fillable = [
        'orcamento_id',
        'produto_id',
        'descricao',
        'largura',
        'altura',
        'quantidade',
        'valor_unitario',
        'valor_total',
        'observacoes',
    ];

    protected $casts = [
        'largura' => 'decimal:3',
        'altura' => 'decimal:3',
        'quantidade' => 'decimal:3',
        'valor_unitario' => 'decimal:2',
        'valor_total' => 'decimal:2',
    ];

    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class)->withTrashed();
    }

    public function produto()
    {
        return $this->belongsTo(Produto::class)->withTrashed();
    }

    /**
     * Área em m² (largura x altura) ou 1 quando o item não é vendido por área.
     */
    public function getAreaAttribute(): float
    {
        return ((float) $this->largura > 0 && (float) $this->altura > 0)
            ? (float) $this->largura * (float) $this->altura
            : 1.0;
    }
}
