<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Colaboradore extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'nome',
        'cpf',
        'cargo',
        'setor',
        'salario',
        'data_admissao',
        'data_demissao',
        'telefone',
        'email',
        'ativo',
        'observacoes',
    ];

    protected $casts = [
        'ativo' => 'boolean',
        'salario' => 'decimal:2',
        'data_admissao' => 'date',
        'data_demissao' => 'date',
    ];
}
