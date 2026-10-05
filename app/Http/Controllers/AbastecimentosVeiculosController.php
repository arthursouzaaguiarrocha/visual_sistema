<?php

namespace App\Http\Controllers;

use App\Models\AbastecimentoVeiculo;
use App\Models\Veiculo;
use Illuminate\Http\Request;

class AbastecimentosVeiculosController extends Controller
{
    public function store(Request $request, Veiculo $veiculo)
    {
        $dados = $request->validate([
            'colaborador_id' => 'nullable|exists:colaboradores,id',
            'data' => 'required|date',
            'km_atual' => 'nullable|integer|min:0',
            'litros' => 'nullable|numeric|min:0',
            'valor_litro' => 'nullable|numeric|min:0',
            'valor_total' => 'required|numeric|min:0',
            'posto' => 'nullable|string|max:255',
        ]);

        $veiculo->abastecimentos()->create($dados);
        $veiculo->registrarKm($dados['km_atual'] ?? null);

        return redirect()->route('veiculos.show', $veiculo)->with('success', 'ABASTECIMENTO REGISTRADO COM SUCESSO');
    }

    public function destroy(AbastecimentoVeiculo $abastecimento)
    {
        $veiculo = $abastecimento->veiculo_id;
        $abastecimento->delete();

        return redirect()->route('veiculos.show', $veiculo)->with('success', 'ABASTECIMENTO REMOVIDO COM SUCESSO');
    }
}
