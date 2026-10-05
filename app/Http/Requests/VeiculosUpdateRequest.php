<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VeiculosUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        if ($this->filled('placa')) {
            $this->merge(['placa' => strtoupper(trim($this->placa))]);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'placa' => ['required', 'string', 'max:10', Rule::unique('veiculos', 'placa')->ignore($this->route('veiculo'))],
            'marca' => 'required|string|max:255',
            'modelo' => 'required|string|max:255',
            'ano_fabricacao' => 'nullable|integer|between:1900,2100',
            'ano_modelo' => 'nullable|integer|between:1900,2100',
            'tipo' => 'nullable|string|max:255',
            'status' => 'required|in:ativo,manutencao,inativo',
            'km_atual' => 'nullable|integer|min:0',
            'data_aquisicao' => 'nullable|date',
            'valor_aquisicao' => 'nullable|numeric|min:0',
            'observacoes' => 'nullable|string',
        ];
    }
}
