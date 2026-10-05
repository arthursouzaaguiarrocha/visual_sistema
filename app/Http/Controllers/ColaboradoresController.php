<?php

namespace App\Http\Controllers;

use App\Models\Colaboradore;
use App\Models\User;
use App\Http\Requests\ColaboradoresUpdateRequest;

class ColaboradoresController extends Controller
{
    public function index()
    { 
        $colaboradores = Colaboradore::all();
        return view('colaboradores.index', compact('colaboradores'));
    }

    public function create()
    {
        $users = User::orderBy('name')->get();
        return view('colaboradores.create', compact('users'));
    }

    public function store(ColaboradoresUpdateRequest $request)
    {
        try{
            Colaboradore::create($request->validated());
            return redirect()->route('colaboradores.index')->with('success', 'COLABORADOR CADASTRADO COM SUCESSO');
        }catch (\Exception $e) {
            return redirect()->route('colaboradores.create')->withInput()->with('error', 'ERRO AO CADASTRAR COLABORADOR: ' . $e->getMessage());
        }
    }

    public function edit(Colaboradore $colaborador)
    {
        $users = User::orderBy('name')->get();
        return view('colaboradores.edit', compact('colaborador', 'users'));
    }

    public function update(ColaboradoresUpdateRequest $request, Colaboradore $colaborador)
    {
        try{
            $colaborador->update($request->validated());
            return redirect()->route('colaboradores.index')->with('success', 'COLABORADOR ATUALIZADO COM SUCESSO');
        }catch (\Exception $e) {
            return redirect()->route('colaboradores.edit', $colaborador)->withInput()->with('error', 'ERRO AO ATUALIZAR COLABORADOR: ' . $e->getMessage());
        }
    }

    public function destroy(Colaboradore $colaborador)
    {
        $colaborador->delete();
        return redirect()->route('colaboradores.index')->with('success', 'COLABORADOR DELETADO COM SUCESSO');
    }
}
