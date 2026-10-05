<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrdensProducaoUpdateRequest;
use App\Models\Colaboradore;
use App\Models\Equipamento;
use App\Models\Orcamento;
use App\Models\OrdemProducao;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class OrdensProducaoController extends Controller
{
    public function index(Request $request)
    {
        $ordens = OrdemProducao::query()
            ->with('orcamento.cliente')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('prioridade'), fn ($q) => $q->where('prioridade', $request->prioridade))
            ->when($request->filled('q'), function ($q) use ($request) {
                $busca = '%' . $request->q . '%';
                $q->where(fn ($w) => $w->where('numero', 'like', $busca)
                    ->orWhereHas('orcamento', fn ($o) => $o->where('numero', 'like', $busca)
                        ->orWhereHas('cliente', fn ($c) => $c->where('nome', 'like', $busca))));
            })
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('ordens_producao.index', compact('ordens'));
    }

    private function formData(): array
    {
        return [
            'colaboradores' => Colaboradore::where('ativo', true)->orderBy('nome')->get(),
            'equipamentos' => Equipamento::where('status', '!=', 'inativo')->orderBy('nome')->get(),
            // Só orçamentos aprovados que ainda não viraram ordem de produção.
            'orcamentos' => Orcamento::with('cliente')
                ->where('status', 'aprovado')
                ->whereDoesntHave('ordemProducao')
                ->orderByDesc('id')
                ->get()
                ->mapWithKeys(fn ($o) => [$o->id => $o->numero . ' — ' . $o->cliente?->nome
                    . ' (R$ ' . number_format($o->valor_total, 2, ',', '.') . ')']),
        ];
    }

    public function create()
    {
        return view('ordens_producao.create', $this->formData());
    }

    public function store(OrdensProducaoUpdateRequest $request)
    {
        try {
            $ordem = DB::transaction(function () use ($request) {
                $dados = Arr::except($request->validated(), ['itens']);
                $orcamento = Orcamento::with('itens')->findOrFail($dados['orcamento_id']);

                $ordem = OrdemProducao::create($dados + ['numero' => OrdemProducao::gerarNumero()]);

                foreach ($orcamento->itens as $item) {
                    $ordem->itens()->create(['orcamento_item_id' => $item->id]);
                }

                return $ordem;
            });

            return redirect()->route('ordens_producao.show', $ordem)->with('success', 'ORDEM DE PRODUÇÃO CRIADA COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('ordens_producao.create')->withInput()->with('error', 'ERRO AO CRIAR ORDEM DE PRODUÇÃO: ' . $e->getMessage());
        }
    }

    public function show(OrdemProducao $ordemProducao)
    {
        $ordemProducao->load(['orcamento.cliente', 'responsavel', 'equipamento', 'itens.orcamentoItem', 'itens.colaborador']);

        return view('ordens_producao.show', compact('ordemProducao'));
    }

    public function edit(OrdemProducao $ordemProducao)
    {
        $ordemProducao->load(['orcamento.cliente', 'itens.orcamentoItem']);

        return view('ordens_producao.edit', array_merge(compact('ordemProducao'), $this->formData()));
    }

    public function update(OrdensProducaoUpdateRequest $request, OrdemProducao $ordemProducao)
    {
        try {
            DB::transaction(function () use ($request, $ordemProducao) {
                $dados = $request->validated();
                $itens = $dados['itens'] ?? [];
                unset($dados['itens']);

                // Preenche automaticamente as datas reais conforme o andamento.
                if (in_array($dados['status'], ['em_producao', 'acabamento', 'finalizado', 'entregue'])
                    && ! $ordemProducao->data_inicio_real && empty($dados['data_inicio_real'])) {
                    $dados['data_inicio_real'] = now();
                }
                if (in_array($dados['status'], ['finalizado', 'entregue'])
                    && ! $ordemProducao->data_conclusao_real && empty($dados['data_conclusao_real'])) {
                    $dados['data_conclusao_real'] = now();
                }

                $ordemProducao->update($dados);

                foreach ($itens as $id => $item) {
                    $ordemProducao->itens()->where('id', $id)->update(Arr::only($item, ['status', 'colaborador_id', 'observacoes']));
                }
            });

            return redirect()->route('ordens_producao.show', $ordemProducao)->with('success', 'ORDEM DE PRODUÇÃO ATUALIZADA COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('ordens_producao.edit', $ordemProducao)->withInput()->with('error', 'ERRO AO ATUALIZAR ORDEM DE PRODUÇÃO: ' . $e->getMessage());
        }
    }

    public function destroy(OrdemProducao $ordemProducao)
    {
        $ordemProducao->delete();

        return redirect()->route('ordens_producao.index')->with('success', 'ORDEM DE PRODUÇÃO DELETADA COM SUCESSO');
    }
}
