<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Acabamento extends Model
{
    protected $table = 'acabamentos';

    protected $fillable = [
        'nome',
        'descricao',
        'unidade_medida',
        'preco',
        'ativo',
    ];

    protected $casts = [
        'preco' => 'decimal:2',
        'ativo' => 'boolean',
    ];

    public function produtos()
    {
        return $this->belongsToMany(Produto::class, 'produto_acabamento')->withTimestamps();
    }
}
