<?php

namespace App\Http\Controllers;

use App\Http\Requests\VeiculosUpdateRequest;
use App\Models\Veiculo;
use App\Models\Colaborador;
use Exception;
use Illuminate\Http\Request;

class VeiculosController extends Controller
{
    public function index(Request $request)
    {
        $veiculos = Veiculo::query()
            ->when($request->filled('q'), function ($q) use ($request) {
                $busca = '%' . $request->q . '%';
                $q->where(fn ($w) => $w->where('placa', 'like', $busca)
                        ->orWhere('marca', 'like', $busca)
                        ->orWhere('modelo', 'like', $busca));
            })
            ->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->orderBy('placa')
            ->paginate(15)
            ->withQueryString();

        return view('veiculos.index', compact('veiculos'));
    }

    private function formData(): array
    {
        return [
            'colaboradores' => Colaborador::where('ativo', true)->orderBy('nome')->get(),
        ];
    }

    public function create()
    {
        return view('veiculos.create', $this->formData());
    }

    public function store(VeiculosUpdateRequest $request)
    {
        try {
            Veiculo::create($request->validated());
            return redirect()->route('veiculos.index')->with('success', 'VEÍCULO CADASTRADO COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('veiculos.create')->withInput()->with('error', 'ERRO AO CADASTRAR VEÍCULO: ' . $e->getMessage());
        }
    }

    public function show(Veiculo $veiculo)
    {
        $veiculo->load(['manutencoes', 'abastecimentos.colaborador']);

        return view('veiculos.show', array_merge(compact('veiculo'), $this->formData()));
    }

    public function edit(Veiculo $veiculo)
    {
        return view('veiculos.edit', array_merge(compact('veiculo'), $this->formData()));
    }

    public function update(VeiculosUpdateRequest $request, Veiculo $veiculo)
    {
        try {
            $veiculo->update($request->validated());
            return redirect()->route('veiculos.index')->with('success', 'VEÍCULO ATUALIZADO COM SUCESSO');
        } catch (Exception $e) {
            return redirect()->route('veiculos.edit', $veiculo)->withInput()->with('error', 'ERRO AO ATUALIZAR VEÍCULO: ' . $e->getMessage());
        }
    }

    public function destroy(Veiculo $veiculo)
    {
        $veiculo->delete();
        return redirect()->route('veiculos.index')->with('success', 'VEÍCULO DELETADO COM SUCESSO');
    }
}
