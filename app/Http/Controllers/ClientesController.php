<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

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
        dd($request->all());
        try{
            $cliente = $request->validate([
                'tipo' => ["string", Rule::in('Pessoa Fisica', 'Pessoa Juridica'), 'required'],
                'nome' => "string|required",
                'nome_fantasia' => "string|nullable",
                'cpf_cnpj' => "string|nullable|unique",
                'rg_ie' => "string|nullable",
                'email' => 'string|nullable|email:rfc,dns',
                'telefone' => 'string|required',
                'whatsapp' => 'string|nullable',
                'cep' => 'string|nullable',
                'endereco' => 'string|nullable',
                'numero' => 'string|nullable',
                'complemento' => 'string|nullable',
                'bairro' => 'string|nullable',
                'cidade' => 'string|nullable',
                'estado' => 'string|nullable|max:2',
                'observacoes' => 'text|nullable',
                'ativo' => 'boolean'
            ]);
            Cliente::create($cliente);  
            return redirect()->route('clientes.index')->with('success', 'CLIENTE CADASTRADO COM SUCESSO');   
        }catch(Exception $e){
            return redirect()->route('clientes.create')->with('message', "ERRO AO CADASTRAR CLIENTE" . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Cliente $cliente)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cliente $cliente)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cliente $cliente)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cliente $cliente)
    {
        //
    }
}
