<?php

namespace App\Http\Controllers;

use App\Models\Equipamento;
use App\Models\ManutencaoEquipamento;
use Illuminate\Http\Request;

class ManutencoesEquipamentosController extends Controller
{
    public function store(Request $request, Equipamento $equipamento)
    {
        $dados = $request->validate([
            'tipo' => 'required|in:preventiva,corretiva',
            'data' => 'required|date',
            'custo' => 'nullable|numeric|min:0',
            'responsavel' => 'nullable|string|max:255',
            'descricao' => 'nullable|string',
        ]);

        $equipamento->manutencoes()->create($dados);

        return redirect()->route('equipamentos.show', $equipamento)->with('success', 'MANUTENÇÃO REGISTRADA COM SUCESSO');
    }

    public function destroy(ManutencaoEquipamento $manutencao)
    {
        $equipamento = $manutencao->equipamento_id;
        $manutencao->delete();

        return redirect()->route('equipamentos.show', $equipamento)->with('success', 'MANUTENÇÃO REMOVIDA COM SUCESSO');
    }
}
