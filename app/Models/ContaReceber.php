<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContaReceber extends Model
{
    use SoftDeletes;

    protected $table = 'contas_receber';

    protected $fillable = [
        'cliente_id',
        'orcamento_id',
        'categoria_financeira_id',
        'colaborador_id',
        'descricao',
        'valor',
        'valor_recebido',
        'data_emissao',
        'data_vencimento',
        'data_recebimento',
        'status',
        'forma_pagamento',
        'numero_documento',
        'observacoes',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'valor_recebido' => 'decimal:2',
        'data_emissao' => 'date',
        'data_vencimento' => 'date',
        'data_recebimento' => 'date',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class)->withTrashed();
    }

    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class)->withTrashed();
    }

    public function categoria()
    {
        return $this->belongsTo(CategoriaFinanceira::class, 'categoria_financeira_id');
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class)->withTrashed();
    }

    public function movimentos()
    {
        return $this->hasMany(FluxoCaixa::class, 'conta_receber_id');
    }

    /**
     * Status exibido: uma conta pendente com vencimento passado aparece como "atrasado".
     */
    public function getStatusEfetivoAttribute(): string
    {
        if ($this->status === 'pendente' && $this->data_vencimento && $this->data_vencimento->lt(today())) {
            return 'atrasado';
        }

        return $this->status;
    }
}
