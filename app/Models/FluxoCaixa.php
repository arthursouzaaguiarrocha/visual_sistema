<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FluxoCaixa extends Model
{
    protected $table = 'fluxo_caixa';

    protected $fillable = [
        'tipo',
        'categoria_financeira_id',
        'conta_pagar_id',
        'conta_receber_id',
        'colaborador_id',
        'descricao',
        'valor',
        'data_movimento',
        'forma_pagamento',
        'observacoes',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'data_movimento' => 'date',
    ];

    public function categoria()
    {
        return $this->belongsTo(CategoriaFinanceira::class, 'categoria_financeira_id');
    }

    public function contaPagar()
    {
        return $this->belongsTo(ContaPagar::class, 'conta_pagar_id')->withTrashed();
    }

    public function contaReceber()
    {
        return $this->belongsTo(ContaReceber::class, 'conta_receber_id')->withTrashed();
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class)->withTrashed();
    }
}
