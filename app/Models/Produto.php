<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produto extends Model
{
    use SoftDeletes;

    protected $table = 'produtos';

    protected $fillable = [
        'nome',
        'categoria',
        'descricao',
        'unidade_medida',
        'preco_base',
        'margem_lucro',
        'tempo_producao_estimado_horas',
        'ativo',
    ];

    protected $casts = [
        'preco_base' => 'decimal:2',
        'margem_lucro' => 'decimal:2',
        'tempo_producao_estimado_horas' => 'decimal:2',
        'ativo' => 'boolean',
    ];

    public function materiasPrimas()
    {
        return $this->belongsToMany(MateriaPrima::class, 'produto_materia_prima')
            ->withPivot('quantidade')
            ->withTimestamps();
    }

    public function acabamentos()
    {
        return $this->belongsToMany(Acabamento::class, 'produto_acabamento')->withTimestamps();
    }

    /**
     * Custo estimado de matéria-prima por unidade do produto.
     */
    public function getCustoEstimadoAttribute(): float
    {
        return (float) $this->materiasPrimas->sum(fn ($m) => (float) $m->preco_custo * (float) $m->pivot->quantidade);
    }
}
