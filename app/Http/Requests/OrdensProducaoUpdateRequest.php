<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class OrdensProducaoUpdateRequest extends FormRequest
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
            'orcamento_id.required' => 'Selecione o orçamento.',
            'orcamento_id.exists' => 'O orçamento precisa existir e estar aprovado.',
            'orcamento_id.unique' => 'Este orçamento já possui uma ordem de produção.',
        ];
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $rules = [
            'colaborador_responsavel_id' => 'nullable|exists:colaboradores,id',
            'equipamento_id' => 'nullable|exists:equipamentos,id',
            'prioridade' => 'required|in:baixa,normal,alta,urgente',
            'status' => 'required|in:fila,em_producao,acabamento,finalizado,entregue,cancelado',
            'data_inicio_prevista' => 'nullable|date',
            'data_entrega_prevista' => 'nullable|date|after_or_equal:data_inicio_prevista',
            'observacoes' => 'nullable|string',
            'data_inicio_real' => 'nullable|date',
            'data_conclusao_real' => 'nullable|date|after_or_equal:data_inicio_real',
            'itens' => 'nullable|array',
            'itens.*.status' => 'required|in:pendente,em_producao,concluido',
            'itens.*.colaborador_id' => 'nullable|exists:colaboradores,id',
            'itens.*.observacoes' => 'nullable|string',
        ];

        // O orçamento só é escolhido na criação da ordem.
        if ($this->isMethod('post')) {
            $rules['orcamento_id'] = [
                'required',
                Rule::exists('orcamentos', 'id')->where('status', 'aprovado')->whereNull('deleted_at'),
                Rule::unique('ordens_producao', 'orcamento_id')->whereNull('deleted_at'),
            ];
        }

        return $rules;
    }
}
