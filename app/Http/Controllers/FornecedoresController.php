<?php

namespace App\Http\Controllers;

use App\Models\Fornecedor;
use App\Http\Requests\FornecedoresUpdateRequest;

class FornecedoresController extends Controller
{
    public function index()
    {
        $fornecedores = Fornecedor::all();
        return view('fornecedores.index', compact('fornecedores'));
    }

    public function create()
    {
        return view('fornecedores.create');
    }

    public function store(FornecedoresUpdateRequest $request)
    {
        try{
            Fornecedor::create($request->validated());
            return redirect()->route('fornecedores.index')->with('success', 'FORNECEDOR CADASTRADO COM SUCESSO');
        }catch (\Exception $e) {
            return redirect()->route('fornecedores.create')->withInput()->with('error', 'ERRO AO CADASTRAR FORNECEDOR: ' . $e->getMessage());
        }
    }

    public function edit(Fornecedor $fornecedor)
    {
        return view('fornecedores.edit', compact('fornecedor'));
    }

    public function update(FornecedoresUpdateRequest $request, Fornecedor $fornecedor)
    {
        try{
            $fornecedor->update($request->validated());
            return redirect()->route('fornecedores.index')->with('success', 'FORNECEDOR ATUALIZADO COM SUCESSO');
        }catch (\Exception $e) {
            return redirect()->route('fornecedores.edit', $fornecedor)->withInput()->with('error', 'ERRO AO ATUALIZAR FORNECEDOR: ' . $e->getMessage());
        }
    }

    public function destroy(Fornecedor $fornecedor)
    {
        $fornecedor->delete();
        return redirect()->route('fornecedores.index')->with('success', 'FORNECEDOR DELETADO COM SUCESSO');
    }
}
