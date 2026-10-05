<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrdemProducaoItem extends Model
{
    protected $table = 'ordens_producao_itens';

    protected $fillable = [
        'ordem_producao_id',
        'orcamento_item_id',
        'colaborador_id',
        'status',
        'observacoes',
    ];

    public function ordem()
    {
        return $this->belongsTo(OrdemProducao::class, 'ordem_producao_id');
    }

    public function orcamentoItem()
    {
        return $this->belongsTo(OrcamentoItem::class);
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class)->withTrashed();
    }
}
