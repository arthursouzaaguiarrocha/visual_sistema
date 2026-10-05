<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AbastecimentoVeiculo extends Model
{
    protected $table = 'abastecimentos_veiculos';

    protected $fillable = [
        'veiculo_id',
        'colaborador_id',
        'data',
        'km_atual',
        'litros',
        'valor_litro',
        'valor_total',
        'posto',
    ];

    protected $casts = [
        'data' => 'date',
        'litros' => 'decimal:2',
        'valor_litro' => 'decimal:3',
        'valor_total' => 'decimal:2',
    ];

    public function veiculo()
    {
        return $this->belongsTo(Veiculo::class)->withTrashed();
    }

    public function colaborador()
    {
        return $this->belongsTo(Colaborador::class)->withTrashed();
    }
}
