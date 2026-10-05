<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class OrcamentosUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function messages(): array
    {
        return [
            'itens.required' => 'Adicione pelo menos um item ao orçamento.',
            'itens.min' => 'Adicione pelo menos um item ao orçamento.',
            'itens.*.descricao.required' => 'Informe a descrição de todos os itens.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'cliente_id' => 'required|exists:clientes,id',
            'colaborador_id' => 'nullable|exists:colaboradores,id',
            'data_orcamento' => 'required|date',
            'data_validade' => 'nullable|date|after_or_equal:data_orcamento',
            'status' => 'required|in:pendente,aprovado,reprovado,expirado,cancelado',
            'forma_pagamento' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
            'valor_desconto' => 'nullable|numeric|min:0',
            'valor_frete' => 'nullable|numeric|min:0',
            'itens' => 'required|array|min:1',
            'itens.*.id' => 'nullable|integer',
            'itens.*.produto_id' => 'nullable|exists:produtos,id',
            'itens.*.descricao' => 'required|string|max:255',
            'itens.*.largura' => 'nullable|numeric|min:0',
            'itens.*.altura' => 'nullable|numeric|min:0',
            'itens.*.quantidade' => 'required|numeric|min:0.001',
            'itens.*.valor_unitario' => 'required|numeric|min:0',
            'itens.*.observacoes' => 'nullable|string',
        ];
    }
}
