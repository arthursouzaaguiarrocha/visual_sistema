<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class MateriasPrimasUpdateRequest extends FormRequest
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
            'fornecedor_id' => 'nullable|exists:fornecedores,id',
            'nome' => 'required|string|max:255',
            'descricao' => 'nullable|string',
            'unidade_medida' => 'required|string|max:10',
            'quantidade_estoque' => 'required|numeric|min:0',
            'estoque_minimo' => 'required|numeric|min:0',
            'preco_custo' => 'required|numeric|min:0',
            'localizacao_estoque' => 'nullable|string|max:255',
            'ativo' => 'boolean',
        ];
    }
}
