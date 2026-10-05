<?php

namespace App\Http\Controllers;

use App\Models\ManutencaoVeiculo;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class ManutencoesVeiculosController extends Controller
{
    public function store(Request $request, Veiculo $veiculo)
    {
        $dados = $request->validate([
            'tipo' => 'required|in:preventiva,corretiva',
            'data' => 'required|date',
            'km_atual' => 'nullable|integer|min:0',
            'custo' => 'nullable|numeric|min:0',
            'descricao' => 'nullable|string',
        ]);

        $veiculo->manutencoes()->create($dados);
        $veiculo->registrarKm($dados['km_atual'] ?? null);

        return redirect()->route('veiculos.show', $veiculo)->with('success', 'MANUTENÇÃO REGISTRADA COM SUCESSO');
    }

    public function destroy(ManutencaoVeiculo $manutencao)
    {
        $veiculo = $manutencao->veiculo_id;
        $manutencao->delete();

        return redirect()->route('veiculos.show', $veiculo)->with('success', 'MANUTENÇÃO REMOVIDA COM SUCESSO');
    }
}
