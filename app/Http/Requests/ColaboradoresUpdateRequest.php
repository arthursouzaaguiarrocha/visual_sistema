<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ColaboradoresUpdateRequest extends FormRequest
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
            'user_id' => 'nullable|exists:users,id',
            'nome' => 'required|string|max:255',
            'cpf' => ['nullable','string','max:14', Rule::unique('colaboradores', 'cpf')->ignore($this->route('colaborador'))],
            'cargo' => 'nullable|string|max:255',
            'setor' => 'nullable|string|max:255',
            'salario' => 'nullable|numeric|min:0',
            'data_admissao' => 'nullable|date',
            'data_demissao' => 'nullable|date|after_or_equal:data_admissao',
            'telefone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'ativo' => 'boolean',
            'observacoes' => 'nullable|string',
        ];
    }
}
