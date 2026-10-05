<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContasReceberUpdateRequest;
use App\Models\CategoriaFinanceira;
use App\Models\Colaborador;
use App\Models\ContaReceber;
use App\Models\FluxoCaixa;
use App\Models\Cliente;
use App\Models\Orcamento;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContasReceberController extends Controller
{
    public function index(Request $request)
    {
        $hoje = today()->toDateString();

        $contas = ContaReceber::query()
            ->with(['cliente', 'categoria', 'orcamento'])
            ->when($request->filled('status'), function ($q) use ($request, $hoje) {
                if ($request->status === 'atrasado') {
                    $q->where(fn ($w) => $w->where('status', 'atrasado')
                        ->orWhere(fn ($x) => $x->where('status', 'pendente')->whereDate('data_vencimento', '<', $hoje)));
                } elseif ($request->status === 'pendente') {
                    $q->where('status', 'pendente')->whereDate('data_vencimento', '>=', $hoje);
                } else {
                    $q->where('status', $request->status);
                }
            })
            ->when($request->filled('de'), fn ($q) => $q->whereDate('data_vencimento', '>=', $request->de))
            ->when($request->filled('ate'), fn ($q) => $q->whereDate('data_vencimento', '<=', $request->ate))
            ->when($request->filled('q'), fn ($q) => $q->where('descricao', 'like', '%' . $request->q . '%'))
            ->orderBy('data_vencimento')
            ->paginate(15)
            ->withQueryString();

        $totalAberto = ContaReceber::whereIn('status', ['pendente', 'atrasado'])->sum('valor');

        return view('contas_receber.index', compact('contas', 'totalAberto'));
    }

    private function formData(): array
    {
        return [
            'clientes' => Cliente::orderBy('nome')->get(),
            'categorias' => CategoriaFinanceira::where('tipo', 'receita')->orderBy('nome')->get(),
            'orcamentos' => Orcamento::with('cliente')->orderByDesc('id')->get()
                ->mapWithKeys(fn ($o) => [$o->id => $o->numero . ' — ' . $o->cliente?->nome]),
        ];
    }

    public function create(Request $request)
    {
        $contaReceber = new ContaReceber(['status' => 'pendente', 'data_emissao' => today()]);

        // Veio do botão "Gerar conta a receber" do orçamento: pré-preenche os dados.
        if ($request->filled('orcamento_id') && $orcamento = Orcamento::find($request->orcamento_id)) {
            $contaReceber->fill([
                'orcamento_id' => $orcamento->id,
                'cliente_id' => $orcamento->cliente_id,
                'valor' => $orcamento->valor_total,
                'descricao' => 'Orçamento ' . $orcamento->numero,
                'forma_pagamento' => $orcamento->forma_pagamento,
            ]);
        }

        return view('contas_receber.create', array_merge(compact('contaReceber'), $this->formData()));
    }

    public function store(ContasReceberUpdateRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['colaborador_id'] = Colaborador::where('user_id', $request->user()->id)->value('id');
            ContaReceber::create($dados);

            return redirect()->route('contas_receber.index')->with('success', 'CONTA A RECEBER CADASTRADA COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('contas_receber.create')->withInput()->with('error', 'ERRO AO CADASTRAR CONTA A RECEBER: ' . $e->getMessage());
        }
    }

    public function edit(ContaReceber $contaReceber)
    {
        return view('contas_receber.edit', array_merge(compact('contaReceber'), $this->formData()));
    }

    public function update(ContasReceberUpdateRequest $request, ContaReceber $contaReceber)
    {
        try {
            $contaReceber->update($request->validated());

            return redirect()->route('contas_receber.index')->with('success', 'CONTA A RECEBER ATUALIZADA COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('contas_receber.edit', $contaReceber)->withInput()->with('error', 'ERRO AO ATUALIZAR CONTA A RECEBER: ' . $e->getMessage());
        }
    }

    public function destroy(ContaReceber $contaReceber)
    {
        $contaReceber->delete();

        return redirect()->route('contas_receber.index')->with('success', 'CONTA A RECEBER DELETADA COM SUCESSO');
    }

    /**
     * Registra a baixa (recebido) e lança a movimentação no fluxo de caixa.
     */
    public function baixar(Request $request, ContaReceber $contaReceber)
    {
        if (in_array($contaReceber->status, ['recebido', 'cancelado'])) {
            return redirect()->back()->with('error', 'ESTA CONTA JÁ ESTÁ ' . strtoupper($contaReceber->status));
        }

        $dados = $request->validate([
            'valor_recebido' => 'nullable|numeric|min:0.01',
            'data_recebimento' => 'nullable|date',
            'forma_pagamento' => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request, $contaReceber, $dados) {
                $valor = $dados['valor_recebido'] ?? $contaReceber->valor;
                $data = $dados['data_recebimento'] ?? today()->toDateString();
                $forma = $dados['forma_pagamento'] ?? $contaReceber->forma_pagamento;

                $contaReceber->update([
                    'valor_recebido' => $valor,
                    'data_recebimento' => $data,
                    'forma_pagamento' => $forma,
                    'status' => 'recebido',
                ]);

                FluxoCaixa::create([
                    'tipo' => 'entrada',
                    'categoria_financeira_id' => $contaReceber->categoria_financeira_id,
                    'conta_receber_id' => $contaReceber->id,
                    'colaborador_id' => Colaborador::where('user_id', $request->user()->id)->value('id'),
                    'descricao' => 'Recebimento: ' . $contaReceber->descricao,
                    'valor' => $valor,
                    'data_movimento' => $data,
                    'forma_pagamento' => $forma,
                ]);
            });

            return redirect()->back()->with('success', 'BAIXA REGISTRADA COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->back()->with('error', 'ERRO AO REGISTRAR BAIXA: ' . $e->getMessage());
        }
    }
}
