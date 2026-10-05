<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Veiculo extends Model
{
    use SoftDeletes;

    protected $table = 'veiculos';

    protected $fillable = [
        'placa',
        'marca',
        'modelo',
        'ano_fabricacao',
        'ano_modelo',
        'tipo',
        'status',
        'km_atual',
        'data_aquisicao',
        'valor_aquisicao',
        'observacoes',
    ];

    protected $casts = [
        'data_aquisicao' => 'date',
        'valor_aquisicao' => 'decimal:2',
        'km_atual' => 'integer',
    ];

    public function manutencoes()
    {
        return $this->hasMany(ManutencaoVeiculo::class)->orderByDesc('data')->orderByDesc('id');
    }

    public function abastecimentos()
    {
        return $this->hasMany(AbastecimentoVeiculo::class)->orderByDesc('data')->orderByDesc('id');
    }

    /**
     * Atualiza o km_atual do veículo se o km informado for maior que o registrado.
     */
    public function registrarKm(?int $km): void
    {
        if ($km && $km > (int) $this->km_atual) {
            $this->update(['km_atual' => $km]);
        }
    }
}
