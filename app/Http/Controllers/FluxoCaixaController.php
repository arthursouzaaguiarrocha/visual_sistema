<?php

namespace App\Http\Controllers;

use App\Http\Requests\FluxoCaixaUpdateRequest;
use App\Models\CategoriaFinanceira;
use App\Models\Colaborador;
use App\Models\FluxoCaixa;
use Exception;
use Illuminate\Http\Request;

class FluxoCaixaController extends Controller
{
    public function index(Request $request)
    {
        $filtro = FluxoCaixa::query()
            ->when($request->filled('tipo'), fn ($q) => $q->where('tipo', $request->tipo))
            ->when($request->filled('categoria'), fn ($q) => $q->where('categoria_financeira_id', $request->categoria))
            ->when($request->filled('de'), fn ($q) => $q->whereDate('data_movimento', '>=', $request->de))
            ->when($request->filled('ate'), fn ($q) => $q->whereDate('data_movimento', '<=', $request->ate))
            ->when($request->filled('q'), fn ($q) => $q->where('descricao', 'like', '%' . $request->q . '%'));

        $entradas = (clone $filtro)->where('tipo', 'entrada')->sum('valor');
        $saidas = (clone $filtro)->where('tipo', 'saida')->sum('valor');

        $movimentos = $filtro->with(['categoria', 'contaPagar', 'contaReceber'])
            ->orderByDesc('data_movimento')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        $categorias = CategoriaFinanceira::orderBy('nome')->get();

        return view('fluxo_caixa.index', compact('movimentos', 'entradas', 'saidas', 'categorias'));
    }

    private function formData(): array
    {
        return [
            'categorias' => CategoriaFinanceira::orderBy('tipo')->orderBy('nome')->get()
                ->mapWithKeys(fn ($c) => [$c->id => $c->nome . ' (' . $c->tipo . ')']),
        ];
    }

    public function create()
    {
        return view('fluxo_caixa.create', $this->formData());
    }

    public function store(FluxoCaixaUpdateRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['colaborador_id'] = Colaborador::where('user_id', $request->user()->id)->value('id');
            FluxoCaixa::create($dados);

            return redirect()->route('fluxo_caixa.index')->with('success', 'MOVIMENTAÇÃO CADASTRADA COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('fluxo_caixa.create')->withInput()->with('error', 'ERRO AO CADASTRAR MOVIMENTAÇÃO: ' . $e->getMessage());
        }
    }

    public function edit(FluxoCaixa $movimento)
    {
        return view('fluxo_caixa.edit', array_merge(compact('movimento'), $this->formData()));
    }

    public function update(FluxoCaixaUpdateRequest $request, FluxoCaixa $movimento)
    {
        try {
            $movimento->update($request->validated());

            return redirect()->route('fluxo_caixa.index')->with('success', 'MOVIMENTAÇÃO ATUALIZADA COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('fluxo_caixa.edit', $movimento)->withInput()->with('error', 'ERRO AO ATUALIZAR MOVIMENTAÇÃO: ' . $e->getMessage());
        }
    }

    public function destroy(FluxoCaixa $movimento)
    {
        $movimento->delete();

        return redirect()->route('fluxo_caixa.index')->with('success', 'MOVIMENTAÇÃO DELETADA COM SUCESSO');
    }
}
