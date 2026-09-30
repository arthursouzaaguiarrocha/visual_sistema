<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $fillable = [
        'tipo',
        'nome',
        'nome_fantasia',
        'cpf_cnpj',
        'rg_ie',
        'email',
        'telefone',
        'whatsapp',
        'cep',
        'endereco',
        'numero',
        'complemento',
        'bairro',
        'cidade',
        'estado',
        'observacoes',
        'ativo'
    ];

    protected $casts = [
        'ativo' => 'boolean'
    ];
}
