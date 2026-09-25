
@extends('layouts.app')

@section('content')

<div class="container mt-4">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2>Clientes</h2>

        <a href="{{ route('clientes.create') }}" class="btn btn-primary">
            + Novo Cliente
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-striped table-hover align-middle">

                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Nome</th>
                            <th>Nome Fantasia</th>
                            <th>CPF/CNPJ</th>
                            <th>Telefone</th>
                            <th>WhatsApp</th>
                            <th>Cidade</th>
                            <th>Estado</th>
                            <th>Status</th>
                            <th class="text-center">Ações</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($clientes as $cliente)

                            <tr>

                                <td>
                                    {{ $cliente->id }}
                                </td>

                                <td>
                                    <strong>{{ $cliente->nome }}</strong>
                                </td>

                                <td>
                                    {{ $cliente->nome_fantasia ?? '-' }}
                                </td>

                                <td>
                                    {{ $cliente->cpf_cnpj ?? '-' }}
                                </td>

                                <td>
                                    {{ $cliente->telefone ?? '-' }}
                                </td>

                                <td>
                                    {{ $cliente->whatsapp ?? '-' }}
                                </td>

                                <td>
                                    {{ $cliente->cidade ?? '-' }}
                                </td>

                                <td>
                                    {{ $cliente->estado ?? '-' }}
                                </td>

                                <td>

                                    @if($cliente->ativo)

                                        <span class="badge bg-success">
                                            Ativo
                                        </span>

                                    @else

                                        <span class="badge bg-danger">
                                            Inativo
                                        </span>

                                    @endif

                                </td>

                                <td class="text-center">

                                    <div class="btn-group">

                                        <!-- Visualizar -->
                                        <a href="{{ route('clientes.show', $cliente->id) }}"
                                           class="btn btn-sm btn-info text-white">
                                            Ver
                                        </a>

                                        <!-- Editar -->
                                        <a href="{{ route('clientes.edit', $cliente->id) }}"
                                           class="btn btn-sm btn-warning">
                                            Editar
                                        </a>

                                        <!-- Excluir -->
                                        <form action="{{ route('clientes.destroy', $cliente->id) }}"
                                              method="POST"
                                              onsubmit="return confirm('Tem certeza que deseja excluir este cliente?')">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-sm btn-danger">
                                                Excluir
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="10" class="text-center py-4">
                                    Nenhum cliente cadastrado.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>
    </div>

</div>

@endsection

