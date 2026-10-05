<?php

namespace App\Models;

use App\Models\Concerns\GeraNumero;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class OrdemProducao extends Model
{
    use SoftDeletes, GeraNumero;

    public const PREFIXO_NUMERO = 'OP';

    protected $table = 'ordens_producao';

    protected $fillable = [
        'orcamento_id',
        'numero',
        'colaborador_responsavel_id',
        'equipamento_id',
        'status',
        'prioridade',
        'data_inicio_prevista',
        'data_entrega_prevista',
        'data_inicio_real',
        'data_conclusao_real',
        'observacoes',
    ];

    protected $casts = [
        'data_inicio_prevista' => 'date',
        'data_entrega_prevista' => 'date',
        'data_inicio_real' => 'datetime',
        'data_conclusao_real' => 'datetime',
    ];

    public function orcamento()
    {
        return $this->belongsTo(Orcamento::class)->withTrashed();
    }

    public function responsavel()
    {
        return $this->belongsTo(Colaborador::class, 'colaborador_responsavel_id')->withTrashed();
    }

    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class)->withTrashed();
    }

    public function itens()
    {
        return $this->hasMany(OrdemProducaoItem::class, 'ordem_producao_id');
    }
}
