<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
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
