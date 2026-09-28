<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreUpdateRequest;
use App\Models\Cliente;
use Exception;
use Illuminate\Http\Request;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        try{
            $cliente = $request->validate([StoreUpdateRequest::clientes()]);
            Cliente::create($cliente);  
            return redirect()->route('clientes.index')->with('success', 'CLIENTE CADASTRADO COM SUCESSO');   
        }catch(Exception $e){
            return redirect()->route('clientes.create')->with('message', "ERRO AO CADASTRAR CLIENTE" . $e->getMessage());
        }
    }

    public function edit(Cliente $cliente)
    {
        $dados = $cliente->findOrFail();
        return view('cliente.edit',compact($dados));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        try{
            $cliente = $request->validate([StoreUpdateRequest::clientes()]);
            Cliente::create($cliente);  
            return redirect()->route('clientes.index')->with('success', 'CLIENTE ATUALIZADO COM SUCESSO');   
        }catch(Exception $e){
            return redirect()->route('clientes.create')->with('error', "ERRO AO ATUALIZAR CLIENTE" . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        $cliente->delete();
        return redirect()->route('clientes.index')->with('success', 'CLIENTE DELETADO COM SUCESSO');  
    }
}
