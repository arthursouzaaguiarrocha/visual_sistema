<?php

namespace App\Http\Controllers;

use App\Http\Requests\AcabamentosUpdateRequest;
use App\Models\Acabamento;
use Exception;
use Illuminate\Http\Request;

class AcabamentosController extends Controller
{
    public function index(Request $request)
    {
        $acabamentos = Acabamento::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $busca = '%' . $request->q . '%';
                $q->where(fn ($w) => $w->where('nome', 'like', $busca));
            })
            ->orderBy('nome')
            ->paginate(15)
            ->withQueryString();

        return view('acabamentos.index', compact('acabamentos'));
    }

    public function create()
    {
        return view('acabamentos.create');
    }

    public function store(AcabamentosUpdateRequest $request)
    {
        try {
            Acabamento::create($request->validated());
            return redirect()->route('acabamentos.index')->with('success', 'ACABAMENTO CADASTRADO COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('acabamentos.create')->withInput()->with('error', 'ERRO AO CADASTRAR ACABAMENTO: ' . $e->getMessage());
        }
    }

    public function edit(Acabamento $acabamento)
    {
        return view('acabamentos.edit', compact('acabamento'));
    }

    public function update(AcabamentosUpdateRequest $request, Acabamento $acabamento)
    {
        try {
            $acabamento->update($request->validated());
            return redirect()->route('acabamentos.index')->with('success', 'ACABAMENTO ATUALIZADO COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('acabamentos.edit', $acabamento)->withInput()->with('error', 'ERRO AO ATUALIZAR ACABAMENTO: ' . $e->getMessage());
        }
    }

    public function destroy(Acabamento $acabamento)
    {
        $acabamento->delete();
        return redirect()->route('acabamentos.index')->with('success', 'ACABAMENTO DELETADO COM SUCESSO');
    }
}
