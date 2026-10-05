<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContasPagarUpdateRequest extends FormRequest
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
            'categoria_financeira_id' => 'nullable|exists:categorias_financeiras,id',
            'descricao' => 'required|string|max:255',
            'valor' => 'required|numeric|min:0.01',
            'data_emissao' => 'nullable|date',
            'data_vencimento' => 'required|date',
            'forma_pagamento' => 'nullable|string|max:255',
            'numero_documento' => 'nullable|string|max:255',
            'status' => 'nullable|in:pendente,atrasado,cancelado',
            'observacoes' => 'nullable|string',
        ];
    }
}
