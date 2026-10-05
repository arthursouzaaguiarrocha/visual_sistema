<?php

namespace App\Http\Controllers;

use App\Http\Requests\EquipamentosUpdateRequest;
use App\Models\Equipamento;
use Exception;
use Illuminate\Http\Request;

class EquipamentosController extends Controller
{
    public function index(Request $request)
    {
        $equipamentos = Equipamento::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $busca = '%' . $request->q . '%';
                $q->where(fn ($w) => $w->where('nome', 'like', $busca)
                        ->orWhere('tipo', 'like', $busca)
                        ->orWhere('marca', 'like', $busca)
                        ->orWhere('modelo', 'like', $busca));
            })
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->orderBy('nome')
            ->paginate(15)
            ->withQueryString();

        return view('equipamentos.index', compact('equipamentos'));
    }

    public function create()
    {
        return view('equipamentos.create');
    }

    public function store(EquipamentosUpdateRequest $request)
    {
        try {
            Equipamento::create($request->validated());
            return redirect()->route('equipamentos.index')->with('success', 'EQUIPAMENTO CADASTRADO COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('equipamentos.create')->withInput()->with('error', 'ERRO AO CADASTRAR EQUIPAMENTO: ' . $e->getMessage());
        }
    }

    public function show(Equipamento $equipamento)
    {
        $equipamento->load(['manutencoes']);

        return view('equipamentos.show', compact('equipamento'));
    }

    public function edit(Equipamento $equipamento)
    {
        return view('equipamentos.edit', compact('equipamento'));
    }

    public function update(EquipamentosUpdateRequest $request, Equipamento $equipamento)
    {
        try {
            $equipamento->update($request->validated());
            return redirect()->route('equipamentos.index')->with('success', 'EQUIPAMENTO ATUALIZADO COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('equipamentos.edit', $equipamento)->withInput()->with('error', 'ERRO AO ATUALIZAR EQUIPAMENTO: ' . $e->getMessage());
        }
    }

    public function destroy(Equipamento $equipamento)
    {
        $equipamento->delete();
        return redirect()->route('equipamentos.index')->with('success', 'EQUIPAMENTO DELETADO COM SUCESSO');
    }
}
