<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ProdutosUpdateRequest extends FormRequest
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
            'nome' => 'required|string|max:255',
            'categoria' => 'nullable|string|max:255',
            'unidade_medida' => 'required|string|max:10',
            'preco_base' => 'required|numeric|min:0',
            'margem_lucro' => 'nullable|numeric|min:0|max:999.99',
            'tempo_producao_estimado_horas' => 'nullable|numeric|min:0',
            'descricao' => 'nullable|string',
            'ativo' => 'boolean',
            'materias_primas' => 'nullable|array',
            'materias_primas.*.materia_prima_id' => 'required|exists:materias_primas,id|distinct',
            'materias_primas.*.quantidade' => 'required|numeric|min:0.0001',
            'acabamentos' => 'nullable|array',
            'acabamentos.*' => 'exists:acabamentos,id',
        ];
    }
}
