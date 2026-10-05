<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Models\MateriaPrima;
use App\Http\Requests\MateriasPrimasUpdateRequest;

class MateriasPrimasController extends Controller
{
    public function index()
    {
        $materias = MateriaPrima::with('fornecedor')->get();
        return view('materias_primas.index', compact('materias'));
    }

    public function create()
    {
        $fornecedores = Fornecedor::orderBy('nome')->get();
        return view('materias_primas.create', compact('fornecedores'));
    }

    public function store(MateriasPrimasUpdateRequest $request)
    {
        try {
            MateriaPrima::create($request->validated());
            return redirect()->route('materias_primas.index')->with('success', 'Matéria-prima criada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao criar matéria-prima.');
        }
    }

    public function edit(MateriaPrima $materia)
    {
        $fornecedores = Fornecedor::orderBy('nome')->get();
        return view('materias_primas.edit', compact('materia', 'fornecedores'));
    }

    public function update(MateriasPrimasUpdateRequest $request, MateriaPrima $materia)
    {
        try {
            $materia->update($request->validated());
            return redirect()->route('materias_primas.index')->with('success', 'Matéria-prima atualizada com sucesso.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Erro ao atualizar matéria-prima.');
        }
    }

    public function destroy(MateriaPrima $materia)
    {
        $materia->delete();
        return redirect()->route('materias_primas.index')->with('success', 'Matéria-prima excluída com sucesso.');
    }
}
