<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Equipamento extends Model
{
    use SoftDeletes;

    protected $table = 'equipamentos';

    protected $fillable = [
        'nome',
        'tipo',
        'marca',
        'modelo',
        'numero_serie',
        'data_aquisicao',
        'valor_aquisicao',
        'status',
        'localizacao',
        'observacoes',
    ];

    protected $casts = [
        'data_aquisicao' => 'date',
        'valor_aquisicao' => 'decimal:2',
    ];

    public function manutencoes()
    {
        return $this->hasMany(ManutencaoEquipamento::class)->orderByDesc('data')->orderByDesc('id');
    }
}
