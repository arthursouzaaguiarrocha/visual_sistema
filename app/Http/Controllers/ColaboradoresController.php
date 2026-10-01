<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Colaborador;

class ColaboradoresController extends Controller
{
    public function index()
    { 
        $colaboradores = Colaborador::all();
        return view('colaboradores.index', compact('colaboradores'));
    }

    public function create()
    {
        return view('colaboradores.create');
    }

    public function store(Request $request)
    {
        try{
            Colaborador::create($request->validated());
            return redirect()->route('colaboradores.index')->with('success', 'COLABORADOR CADASTRADO COM SUCESSO');
        }catch (\Exception $e) {
            return redirect()->route('colaboradores.create')->withInput()->with('error', 'ERRO AO CADASTRAR COLABORADOR: ' . $e->getMessage());
        }
    }

    public function edit(Colaborador $colaborador)
    {
        return view('colaboradores.edit', compact('colaborador'));
    }

    public function update(Request $request, Colaborador $colaborador)
    {
        try{
            $colaborador->update($request->validated());
            return redirect()->route('colaboradores.index')->with('success', 'COLABORADOR ATUALIZADO COM SUCESSO');
        }catch (\Exception $e) {
            return redirect()->route('colaboradores.edit', $colaborador)->withInput()->with('error', 'ERRO AO ATUALIZAR COLABORADOR: ' . $e->getMessage());
        }
    }

    public function destroy(Colaborador $colaborador)
    {
        $colaborador->delete();
        return redirect()->route('colaboradores.index')->with('success', 'COLABORADOR DELETADO COM SUCESSO');
    }
}
