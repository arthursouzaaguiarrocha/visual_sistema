<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-900">Orçamentos</h2>
            <a href="{{ route('orcamentos.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">+ Orçamento</a>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-flash />

            <form method="GET" class="mb-4 flex flex-wrap items-end gap-3">
                <div><label class="block text-xs font-medium text-slate-500">Buscar</label><input type="text" name="q" value="{{ request('q') }}" class="mt-1 rounded-md border-slate-200 text-sm shadow-sm"></div>
                <div><label class="block text-xs font-medium text-slate-500">Status</label><select name="status" class="mt-1 rounded-md border-slate-200 text-sm shadow-sm"><option value="">Todos</option>
                    <option value="pendente" @selected(request('status') === 'pendente')>Pendente</option>
                    <option value="aprovado" @selected(request('status') === 'aprovado')>Aprovado</option>
                    <option value="reprovado" @selected(request('status') === 'reprovado')>Reprovado</option>
                    <option value="expirado" @selected(request('status') === 'expirado')>Expirado</option>
                    <option value="cancelado" @selected(request('status') === 'cancelado')>Cancelado</option>
                </select></div>
                <button class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">Filtrar</button>
                @if (request()->query())
                    <a href="{{ url()->current() }}" class="text-sm text-slate-600 underline">Limpar</a>
                @endif
            </form>
            <div class="overflow-x-auto rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Número</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Cliente</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Data</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Validade</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Total</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($orcamentos as $item)
                        <tr class="hover:bg-slate-50/80">
                            <td class="px-4 py-3 text-slate-700">{{ $item->numero }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $item->cliente?->nome }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $item->data_orcamento?->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-slate-700">{{ $item->data_validade?->format('d/m/Y') }}</td>
                            <td class="px-4 py-3 text-slate-700">R$ {{ number_format((float) $item->valor_total, 2, ',', '.') }}</td>
                            <td class="px-4 py-3 text-slate-700"><x-badge :value="$item->status" /></td>
                            <td class="whitespace-nowrap px-4 py-3 text-right">
                                <a href="{{ route('orcamentos.show', $item) }}" class="mr-3 text-slate-600 hover:underline">Ver</a>
                                <a href="{{ route('orcamentos.edit', $item) }}" class="mr-3 text-indigo-600 hover:underline">Editar</a>
                                <form method="POST" action="{{ route('orcamentos.destroy', $item) }}" class="inline" onsubmit="return confirm('Excluir este registro?')">
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

            <div class="mt-4">{{ $orcamentos->links() }}</div>
        </div>
    </div>
</x-app-layout>
