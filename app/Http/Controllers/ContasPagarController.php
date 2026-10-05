<?php

namespace App\Http\Controllers;

use App\Http\Requests\ContasPagarUpdateRequest;
use App\Models\CategoriaFinanceira;
use App\Models\Colaborador;
use App\Models\ContaPagar;
use App\Models\FluxoCaixa;
use App\Models\Fornecedor;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContasPagarController extends Controller
{
    public function index(Request $request)
    {
        $hoje = today()->toDateString();

        $contas = ContaPagar::query()
            ->with(['fornecedor', 'categoria'])
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

        $totalAberto = ContaPagar::whereIn('status', ['pendente', 'atrasado'])->sum('valor');

        return view('contas_pagar.index', compact('contas', 'totalAberto'));
    }

    private function formData(): array
    {
        return [
            'fornecedores' => Fornecedor::orderBy('nome')->get(),
            'categorias' => CategoriaFinanceira::where('tipo', 'despesa')->orderBy('nome')->get(),
        ];
    }

    public function create(Request $request)
    {
        $contaPagar = new ContaPagar(['status' => 'pendente', 'data_emissao' => today()]);

        return view('contas_pagar.create', array_merge(compact('contaPagar'), $this->formData()));
    }

    public function store(ContasPagarUpdateRequest $request)
    {
        try {
            $dados = $request->validated();
            $dados['colaborador_id'] = Colaborador::where('user_id', $request->user()->id)->value('id');
            ContaPagar::create($dados);

            return redirect()->route('contas_pagar.index')->with('success', 'CONTA A PAGAR CADASTRADA COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('contas_pagar.create')->withInput()->with('error', 'ERRO AO CADASTRAR CONTA A PAGAR: ' . $e->getMessage());
        }
    }

    public function edit(ContaPagar $contaPagar)
    {
        return view('contas_pagar.edit', array_merge(compact('contaPagar'), $this->formData()));
    }

    public function update(ContasPagarUpdateRequest $request, ContaPagar $contaPagar)
    {
        try {
            $contaPagar->update($request->validated());

            return redirect()->route('contas_pagar.index')->with('success', 'CONTA A PAGAR ATUALIZADA COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('contas_pagar.edit', $contaPagar)->withInput()->with('error', 'ERRO AO ATUALIZAR CONTA A PAGAR: ' . $e->getMessage());
        }
    }

    public function destroy(ContaPagar $contaPagar)
    {
        $contaPagar->delete();

        return redirect()->route('contas_pagar.index')->with('success', 'CONTA A PAGAR DELETADA COM SUCESSO');
    }

    /**
     * Registra a baixa (pago) e lança a movimentação no fluxo de caixa.
     */
    public function baixar(Request $request, ContaPagar $contaPagar)
    {
        if (in_array($contaPagar->status, ['pago', 'cancelado'])) {
            return redirect()->back()->with('error', 'ESTA CONTA JÁ ESTÁ ' . strtoupper($contaPagar->status));
        }

        $dados = $request->validate([
            'valor_pago' => 'nullable|numeric|min:0.01',
            'data_pagamento' => 'nullable|date',
            'forma_pagamento' => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request, $contaPagar, $dados) {
                $valor = $dados['valor_pago'] ?? $contaPagar->valor;
                $data = $dados['data_pagamento'] ?? today()->toDateString();
                $forma = $dados['forma_pagamento'] ?? $contaPagar->forma_pagamento;

                $contaPagar->update([
                    'valor_pago' => $valor,
                    'data_pagamento' => $data,
                    'forma_pagamento' => $forma,
                    'status' => 'pago',
                ]);

                FluxoCaixa::create([
                    'tipo' => 'saida',
                    'categoria_financeira_id' => $contaPagar->categoria_financeira_id,
                    'conta_pagar_id' => $contaPagar->id,
                    'colaborador_id' => Colaborador::where('user_id', $request->user()->id)->value('id'),
                    'descricao' => 'Pagamento: ' . $contaPagar->descricao,
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
