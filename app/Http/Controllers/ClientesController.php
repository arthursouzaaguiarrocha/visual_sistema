<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientesUpdateRequest;
use App\Models\Cliente;
use Exception;

class ClientesController extends Controller
{
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(ClientesUpdateRequest $request)
    {
        try {
            Cliente::create($request->validated());
            return redirect()->route('clientes.index')->with('success', 'CLIENTE CADASTRADO COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('clientes.create')->withInput()->with('error', 'ERRO AO CADASTRAR CLIENTE: ' . $e->getMessage());
        }
    }

    public function edit(Cliente $cliente)
    {
        return view('clientes.edit', compact('cliente'));
    }

    public function update(ClientesUpdateRequest $request, Cliente $cliente)
    {
        try {
            $cliente->update($request->validated());
            return redirect()->route('clientes.index')->with('success', 'CLIENTE ATUALIZADO COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('clientes.edit', $cliente)->withInput()->with('error', 'ERRO AO ATUALIZAR CLIENTE: ' . $e->getMessage());
        }
    }

    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'CLIENTE DELETADO COM SUCESSO');
    }
}
