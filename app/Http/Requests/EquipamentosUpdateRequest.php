<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EquipamentosUpdateRequest extends FormRequest
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
            'tipo' => 'nullable|string|max:255',
            'marca' => 'nullable|string|max:255',
            'modelo' => 'nullable|string|max:255',
            'numero_serie' => ['nullable', 'string', 'max:255', Rule::unique('equipamentos', 'numero_serie')->ignore($this->route('equipamento'))],
            'data_aquisicao' => 'nullable|date',
            'valor_aquisicao' => 'nullable|numeric|min:0',
            'status' => 'required|in:ativo,manutencao,inativo',
            'localizacao' => 'nullable|string|max:255',
            'observacoes' => 'nullable|string',
        ];
    }
}
