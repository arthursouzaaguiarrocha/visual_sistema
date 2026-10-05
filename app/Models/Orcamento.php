<?php

namespace App\Models;

use App\Models\Concerns\GeraNumero;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Orcamento extends Model
{
    use SoftDeletes, GeraNumero;

    public const PREFIXO_NUMERO = 'ORC';

    protected $table = 'orcamentos';

    protected $fillable = [
        'numero',
        'cliente_id',
        'colaborador_id',
        'data_orcamento',
        'data_validade',
        'status',
        'valor_desconto',
        'valor_frete',
        'valor_total',
        'forma_pagamento',
        'observacoes',
    ];

    protected $casts = [
        'data_orcamento' => 'date',
        'data_validade' => 'date',
        'valor_desconto' => 'decimal:2',
        'valor_frete' => 'decimal:2',
        'valor_total' => 'decimal:2',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class)->withTrashed();
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class)->withTrashed();
    }

    public function itens()
    {
        return $this->hasMany(OrcamentoItem::class);
    }

    public function ordemProducao()
    {
        return $this->hasOne(OrdemProducao::class);
    }

    public function contasReceber()
    {
        return $this->hasMany(ContaReceber::class);
    }

    public function getSubtotalAttribute(): float
    {
        return (float) $this->itens->sum('valor_total');
    }
}
