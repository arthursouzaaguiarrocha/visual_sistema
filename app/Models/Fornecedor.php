<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Fornecedor extends Model
{
    use SoftDeletes;

    protected $table = 'fornecedores';

    protected $fillable = [
        'nome',
        'cnpj_cpf',
        'contato_nome',
        'telefone',
        'email',
        'cep',
        'endereco',
        'cidade',
        'estado',
        'observacoes',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean',
    ];
}
