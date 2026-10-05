<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-900">Clientes</h2>
            <a href="{{ route('clientes.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">+ Cliente</a>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash />


            <div class="overflow-x-auto rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Nome</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Tipo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">CPF/CNPJ</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Telefone</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Cidade</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($clientes as $item)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-3 text-slate-700">{{ $item->nome }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $item->tipo }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $item->cpf_cnpj }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $item->telefone }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $item->cidade }}</td>
                            <td class="px-4 py-3 text-slate-700"><x-badge :value="$item->ativo ? 'ativo' : 'inativo'" /></td>
                            <td class="whitespace-nowrap px-4 py-3 text-right">
                                <a href="{{ route('clientes.edit', $item) }}" class="mr-3 text-indigo-600 hover:underline">Editar</a>
                                <form method="POST" action="{{ route('clientes.destroy', $item) }}" class="inline" onsubmit="return confirm('Excluir este registro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-600 hover:underline">Excluir</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr><td colspan="7" class="px-4 py-8 text-center text-slate-500">Nenhum registro encontrado.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>
