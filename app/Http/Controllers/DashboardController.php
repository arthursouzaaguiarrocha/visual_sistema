<?php

namespace App\Http\Controllers;

use App\Models\ContaPagar;
use App\Models\ContaReceber;
use App\Models\FluxoCaixa;
use App\Models\MateriaPrima;
use App\Models\Orcamento;
use App\Models\OrdemProducao;

class DashboardController extends Controller
{
    public function index()
    {
        $hoje = today();
        $inicioMes = $hoje->copy()->startOfMonth()->toDateString();
        $fimMes = $hoje->copy()->endOfMonth()->toDateString();

        $aReceber = ContaReceber::whereIn('status', ['pendente', 'atrasado']);
        $aPagar = ContaPagar::whereIn('status', ['pendente', 'atrasado']);

        $entradasMes = FluxoCaixa::where('tipo', 'entrada')->whereBetween('data_movimento', [$inicioMes, $fimMes])->sum('valor');
        $saidasMes = FluxoCaixa::where('tipo', 'saida')->whereBetween('data_movimento', [$inicioMes, $fimMes])->sum('valor');

        return view('dashboard', [
            'totalReceber' => (clone $aReceber)->sum('valor'),
            'receberVencidas' => (clone $aReceber)->whereDate('data_vencimento', '<', $hoje)->count(),
            'totalPagar' => (clone $aPagar)->sum('valor'),
            'pagarVencidas' => (clone $aPagar)->whereDate('data_vencimento', '<', $hoje)->count(),
            'saldoMes' => $entradasMes - $saidasMes,
            'orcamentosPendentes' => Orcamento::where('status', 'pendente')->count(),
            'ordensAbertas' => OrdemProducao::whereIn('status', ['fila', 'em_producao', 'acabamento'])->count(),
            'estoqueBaixo' => MateriaPrima::where('ativo', true)
                ->where('estoque_minimo', '>', 0)
                ->whereColumn('quantidade_estoque', '<=', 'estoque_minimo')
                ->count(),
            'proximasEntregas' => OrdemProducao::with('orcamento.cliente')
                ->whereIn('status', ['fila', 'em_producao', 'acabamento'])
                ->orderByRaw('data_entrega_prevista is null')
                ->orderBy('data_entrega_prevista')
                ->limit(6)
                ->get(),
        ]);
    }
}
