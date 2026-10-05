<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContaPagar extends Model
{
    use SoftDeletes;

    protected $table = 'contas_pagar';

    protected $fillable = [
        'fornecedor_id',
        'categoria_financeira_id',
        'colaborador_id',
        'descricao',
        'valor',
        'valor_pago',
        'data_emissao',
        'data_vencimento',
        'data_pagamento',
        'status',
        'forma_pagamento',
        'numero_documento',
        'observacoes',
    ];

    protected $casts = [
        'valor' => 'decimal:2',
        'valor_pago' => 'decimal:2',
        'data_emissao' => 'date',
        'data_vencimento' => 'date',
        'data_pagamento' => 'date',
    ];

    public function fornecedor()
    {
        return $this->belongsTo(Fornecedor::class)->withTrashed();
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
        return $this->hasMany(FluxoCaixa::class, 'conta_pagar_id');
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
