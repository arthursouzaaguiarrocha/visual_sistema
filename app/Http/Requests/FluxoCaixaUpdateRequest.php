<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FluxoCaixaUpdateRequest extends FormRequest
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
            'tipo' => 'required|in:entrada,saida',
            'data_movimento' => 'required|date',
            'valor' => 'required|numeric|min:0.01',
            'descricao' => 'required|string|max:255',
            'categoria_financeira_id' => 'nullable|exists:categorias_financeiras,id',
            'forma_pagamento' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
        ];
    }
}
