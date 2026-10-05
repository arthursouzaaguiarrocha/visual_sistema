<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriasFinanceirasUpdateRequest;
use App\Models\CategoriaFinanceira;
use Exception;
use Illuminate\Http\Request;

class CategoriasFinanceirasController extends Controller
{
    public function index(Request $request)
    {
        $categorias = CategoriaFinanceira::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $busca = '%' . $request->q . '%';
                $q->where(fn ($w) => $w->where('nome', 'like', $busca));
            })
            ->when($request->filled('tipo'), fn ($q) => $q->where('tipo', $request->tipo))
            ->orderBy('nome')
            ->paginate(15)
            ->withQueryString();

        return view('categorias_financeiras.index', compact('categorias'));
    }

    public function create()
    {
        return view('categorias_financeiras.create');
    }

    public function store(CategoriasFinanceirasUpdateRequest $request)
    {
        try {
            CategoriaFinanceira::create($request->validated());
            return redirect()->route('categorias_financeiras.index')->with('success', 'CATEGORIA CADASTRADA COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('categorias_financeiras.create')->withInput()->with('error', 'ERRO AO CADASTRAR CATEGORIA: ' . $e->getMessage());
        }
    }

    public function edit(CategoriaFinanceira $categoriaFinanceira)
    {
        return view('categorias_financeiras.edit', compact('categoriaFinanceira'));
    }

    public function update(CategoriasFinanceirasUpdateRequest $request, CategoriaFinanceira $categoriaFinanceira)
    {
        try {
            $categoriaFinanceira->update($request->validated());
            return redirect()->route('categorias_financeiras.index')->with('success', 'CATEGORIA ATUALIZADA COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('categorias_financeiras.edit', $categoriaFinanceira)->withInput()->with('error', 'ERRO AO ATUALIZAR CATEGORIA: ' . $e->getMessage());
        }
    }

    public function destroy(CategoriaFinanceira $categoriaFinanceira)
    {
        $categoriaFinanceira->delete();
        return redirect()->route('categorias_financeiras.index')->with('success', 'CATEGORIA DELETADA COM SUCESSO');
    }
}
