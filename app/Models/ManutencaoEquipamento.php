<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManutencaoEquipamento extends Model
{
    protected $table = 'manutencoes_equipamentos';

    protected $fillable = [
        'equipamento_id',
        'tipo',
        'data',
        'custo',
        'descricao',
        'responsavel',
    ];

    protected $casts = [
        'data' => 'date',
        'custo' => 'decimal:2',
    ];

    public function equipamento()
    {
        return $this->belongsTo(Equipamento::class)->withTrashed();
    }
}
