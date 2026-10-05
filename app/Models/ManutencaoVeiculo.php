<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManutencaoVeiculo extends Model
{
    protected $table = 'manutencoes_veiculos';

    protected $fillable = [
        'veiculo_id',
        'tipo',
        'data',
        'km_atual',
        'custo',
        'descricao',
    ];

    protected $casts = [
        'data' => 'date',
        'custo' => 'decimal:2',
    ];

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class)->withTrashed();
    }
}
