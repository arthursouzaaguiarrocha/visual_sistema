<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MateriaPrima;

class MateriasPrimasController extends Controller
{
    public function index()
    {
        $materias = MateriaPrima::all();
        return view('materias_primas.index', compact('materias'));
    }

    public function create()
    {
        return view('materias_primas.create');
    }

    public function store(Request $request)
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
        return view('materias_primas.edit', compact('materia'));
    }

    public function update(Request $request, MateriaPrima $materia)
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
