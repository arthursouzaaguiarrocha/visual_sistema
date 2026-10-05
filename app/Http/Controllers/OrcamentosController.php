<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrcamentosUpdateRequest;
use App\Models\Cliente;
use App\Models\Colaboradore;
use App\Models\Orcamento;
use App\Models\Produto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class OrcamentosController extends Controller
{
    public function index(Request $request)
    {
        $orcamentos = Orcamento::query()
            ->with('cliente')
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('q'), function ($q) use ($request) {
                $busca = '%' . $request->q . '%';
                $q->where(fn ($w) => $w->where('numero', 'like', $busca)
                    ->orWhereHas('cliente', fn ($c) => $c->where('nome', 'like', $busca)));
            })
            ->orderByDesc('data_orcamento')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        return view('orcamentos.index', compact('orcamentos'));
    }

    private function formData(): array
    {
        return [
            'clientes' => Cliente::where('ativo', true)->orderBy('nome')->get(),
            'colaboradores' => Colaboradore::where('ativo', true)->orderBy('nome')->get(),
            'produtos' => Produto::where('ativo', true)->orderBy('nome')->get(),
            'colaboradorLogado' => Colaboradore::where('user_id', auth()->id())->value('id'),
        ];
    }

    /**
     * Total da linha: (largura x altura, se informadas) x quantidade x valor unitário.
     */
    private function totalItem(array $item): float
    {
        $largura = (float) ($item['largura'] ?? 0);
        $altura = (float) ($item['altura'] ?? 0);
        $area = ($largura > 0 && $altura > 0) ? $largura * $altura : 1;

        return round($area * (float) $item['quantidade'] * (float) $item['valor_unitario'], 2);
    }

    /**
     * Grava os itens (mantendo os ids existentes) e recalcula o total do orçamento.
     */
    private function salvarItens(Orcamento $orcamento, array $dados): void
    {
        $mantidos = [];
        $subtotal = 0;

        foreach ($dados['itens'] as $item) {
            $item['valor_total'] = $this->totalItem($item);
            $subtotal += $item['valor_total'];
            $campos = Arr::except($item, ['id']);

            $existente = ! empty($item['id']) ? $orcamento->itens()->find($item['id']) : null;

            if ($existente) {
                $existente->update($campos);
                $mantidos[] = $existente->id;
            } else {
                $mantidos[] = $orcamento->itens()->create($campos)->id;
            }
        }

        $orcamento->itens()->whereNotIn('id', $mantidos)->delete();

        $total = $subtotal - (float) ($dados['valor_desconto'] ?? 0) + (float) ($dados['valor_frete'] ?? 0);
        $orcamento->update(['valor_total' => max(0, round($total, 2))]);
    }

    private function cabecalho(array $dados): array
    {
        $dados = Arr::except($dados, ['itens']);
        $dados['valor_desconto'] = $dados['valor_desconto'] ?? 0;
        $dados['valor_frete'] = $dados['valor_frete'] ?? 0;

        return $dados;
    }

    public function create()
    {
        return view('orcamentos.create', $this->formData());
    }

    public function store(OrcamentosUpdateRequest $request)
    {
        try {
            $orcamento = DB::transaction(function () use ($request) {
                $dados = $request->validated();
                $orcamento = Orcamento::create($this->cabecalho($dados) + ['numero' => Orcamento::gerarNumero()]);
                $this->salvarItens($orcamento, $dados);

                return $orcamento;
            });

            return redirect()->route('orcamentos.show', $orcamento)->with('success', 'ORÇAMENTO CADASTRADO COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('orcamentos.create')->withInput()->with('error', 'ERRO AO CADASTRAR ORÇAMENTO: ' . $e->getMessage());
        }
    }

    public function show(Orcamento $orcamento)
    {
        $orcamento->load(['cliente', 'colaborador', 'itens', 'ordemProducao', 'contasReceber']);

        return view('orcamentos.show', compact('orcamento'));
    }

    public function edit(Orcamento $orcamento)
    {
        $orcamento->load('itens');

        return view('orcamentos.edit', array_merge(compact('orcamento'), $this->formData()));
    }

    public function update(OrcamentosUpdateRequest $request, Orcamento $orcamento)
    {
        try {
            DB::transaction(function () use ($request, $orcamento) {
                $dados = $request->validated();
                $orcamento->update($this->cabecalho($dados));
                $this->salvarItens($orcamento, $dados);
            });

            return redirect()->route('orcamentos.show', $orcamento)->with('success', 'ORÇAMENTO ATUALIZADO COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('orcamentos.edit', $orcamento)->withInput()->with('error', 'ERRO AO ATUALIZAR ORÇAMENTO: ' . $e->getMessage());
        }
    }

    public function destroy(Orcamento $orcamento)
    {
        if ($orcamento->ordemProducao()->exists()) {
            return redirect()->route('orcamentos.index')->with('error', 'NÃO É POSSÍVEL EXCLUIR: O ORÇAMENTO POSSUI ORDEM DE PRODUÇÃO');
        }

        $orcamento->delete();

        return redirect()->route('orcamentos.index')->with('success', 'ORÇAMENTO DELETADO COM SUCESSO');
    }
}
