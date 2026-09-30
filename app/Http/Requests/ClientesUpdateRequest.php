<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ClientesUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'tipo' => ["string", Rule::in('Pessoa Fisica', 'Pessoa Juridica'), 'required'],
            'nome' => "string|required",
            'nome_fantasia' => "string|nullable",
            'cpf_cnpj' => [
                'nullable',
                'string',
                Rule::unique('clientes', 'cpf_cnpj')->ignore($this->route('cliente')),
            ],
            'rg_ie' => "string|nullable",
            'email' => 'string|nullable|email:rfc,dns',
            'telefone' => 'string|required',
            'whatsapp' => 'string|nullable',
            'cep' => 'string|nullable',
            'endereco' => 'string|nullable',
            'numero' => 'string|nullable',
            'complemento' => 'string|nullable',
            'bairro' => 'string|nullable',
            'cidade' => 'string|nullable',
            'estado' => 'string|nullable|max:2',
            'observacoes' => 'text|nullable',
            'ativo' => 'boolean'
        ];
    }
}
