<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-900">Colaboradores</h2>
            <a href="{{ route('colaboradores.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">+ Colaborador</a>
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
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Cargo</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Setor</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Telefone</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Admissão</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($colaboradores as $item)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-3 text-slate-700">{{ $item->nome }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $item->cargo }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $item->setor }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $item->telefone }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $item->data_admissao?->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-slate-700"><x-badge :value="$item->ativo ? 'ativo' : 'inativo'" /></td>
                            <td class="whitespace-nowrap px-4 py-3 text-right">
                                <a href="{{ route('colaboradores.edit', $item) }}" class="mr-3 text-indigo-600 hover:underline">Editar</a>
                                <form method="POST" action="{{ route('colaboradores.destroy', $item) }}" class="inline" onsubmit="return confirm('Excluir este registro?')">
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
