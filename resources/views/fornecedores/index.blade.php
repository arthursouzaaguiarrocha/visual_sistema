@extends('layouts.bootstrap')
@section('titulo', 'Fornecedores')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Fornecedores</h1>
    <a href="{{ route('fornecedores.create') }}" class="btn btn-primary">+ Novo fornecedor</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table table-hover align-middle mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nome</th>
                    <th>CNPJ/CPF</th>
                    <th>Contato</th>
                    <th>Telefone</th>
                    <th>Cidade/UF</th>
                    <th>Status</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($fornecedores as $fornecedor)
                    <tr>
                        <td>{{ $fornecedor->nome }}</td>
                        <td>{{ $fornecedor->cnpj_cpf }}</td>
                        <td>{{ $fornecedor->contato_nome }}</td>
                        <td>{{ $fornecedor->telefone }}</td>
                        <td>{{ $fornecedor->cidade }}{{ $fornecedor->estado ? '/' . $fornecedor->estado : '' }}</td>
                        <td><x-status :ativo="$fornecedor->ativo" /></td>
                        <x-acoes :editar="route('fornecedores.edit', $fornecedor)"
                                 :excluir="route('fornecedores.destroy', $fornecedor)"
                                 confirmar="Excluir este fornecedor?" />
                    </tr>
                @empty
                    <tr><td colspan="7" class="text-center text-muted py-4">Nenhum fornecedor cadastrado.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
