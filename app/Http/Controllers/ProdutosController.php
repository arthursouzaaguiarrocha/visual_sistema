<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProdutosUpdateRequest;
use App\Models\Acabamento;
use App\Models\MateriaPrima;
use App\Models\Produto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;

class ProdutosController extends Controller
{
    public function index(Request $request)
    {
        $produtos = Produto::query()
            ->with('materiasPrimas')
            ->when($request->filled('q'), function ($q) use ($request) {
                $busca = '%' . $request->q . '%';
                $q->where(fn ($w) => $w->where('nome', 'like', $busca)->orWhere('categoria', 'like', $busca));
            })
            ->orderBy('nome')
            ->paginate(15)
            ->withQueryString();

        return view('produtos.index', compact('produtos'));
    }

    private function formData(): array
    {
        return [
            'materias' => MateriaPrima::orderBy('nome')->get(),
            'acabamentos' => Acabamento::orderBy('nome')->get(),
        ];
    }

    private function sincronizar(Produto $produto, array $dados): void
    {
        $materias = collect($dados['materias_primas'] ?? [])
            ->mapWithKeys(fn ($i) => [$i['materia_prima_id'] => ['quantidade' => $i['quantidade']]])
            ->all();

        $produto->materiasPrimas()->sync($materias);
        $produto->acabamentos()->sync($dados['acabamentos'] ?? []);
    }

    public function create()
    {
        return view('produtos.create', $this->formData());
    }

    public function store(ProdutosUpdateRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $dados = $request->validated();
                $produto = Produto::create(Arr::except($dados, ['materias_primas', 'acabamentos']));
                $this->sincronizar($produto, $dados);
            });

            return redirect()->route('produtos.index')->with('success', 'PRODUTO CADASTRADO COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('produtos.create')->withInput()->with('error', 'ERRO AO CADASTRAR PRODUTO: ' . $e->getMessage());
        }
    }

    public function edit(Produto $produto)
    {
        $produto->load('materiasPrimas', 'acabamentos');

        return view('produtos.edit', array_merge(compact('produto'), $this->formData()));
    }

    public function update(ProdutosUpdateRequest $request, Produto $produto)
    {
        try {
            DB::transaction(function () use ($request, $produto) {
                $dados = $request->validated();
                $produto->update(Arr::except($dados, ['materias_primas', 'acabamentos']));
                $this->sincronizar($produto, $dados);
            });

            return redirect()->route('produtos.index')->with('success', 'PRODUTO ATUALIZADO COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('produtos.edit', $produto)->withInput()->with('error', 'ERRO AO ATUALIZAR PRODUTO: ' . $e->getMessage());
        }
    }

    public function destroy(Produto $produto)
    {
        $produto->delete();

        return redirect()->route('produtos.index')->with('success', 'PRODUTO DELETADO COM SUCESSO');
    }
}
