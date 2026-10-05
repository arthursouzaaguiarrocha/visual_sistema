<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-900">{{ $equipamento->nome }}</h2>
            <a href="{{ route('equipamentos.edit', $equipamento) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">Editar</a>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            <x-flash />

            <div class="grid grid-cols-2 gap-4 bg-white p-6 text-sm shadow-sm sm:rounded-lg md:grid-cols-4">
                <div><p class="text-xs uppercase text-slate-500">Tipo</p><p class="text-slate-900">{{ $equipamento->tipo ?? '—' }}</p></div>
                <div><p class="text-xs uppercase text-slate-500">Marca / Modelo</p><p class="text-slate-900">{{ trim($equipamento->marca . ' ' . $equipamento->modelo) ?: '—' }}</p></div>
                <div><p class="text-xs uppercase text-slate-500">Nº de série</p><p class="text-slate-900">{{ $equipamento->numero_serie ?? '—' }}</p></div>
                <div><p class="text-xs uppercase text-slate-500">Status</p><x-badge :value="$equipamento->status" /></div>
                <div><p class="text-xs uppercase text-slate-500">Localização</p><p class="text-slate-900">{{ $equipamento->localizacao ?? '—' }}</p></div>
                <div><p class="text-xs uppercase text-slate-500">Aquisição</p><p class="text-slate-900">{{ $equipamento->data_aquisicao?->format('d/m/Y') ?? '—' }}</p></div>
                <div><p class="text-xs uppercase text-slate-500">Valor de aquisição</p><p class="text-slate-900">{{ $equipamento->valor_aquisicao ? 'R$ ' . number_format($equipamento->valor_aquisicao, 2, ',', '.') : '—' }}</p></div>
                <div><p class="text-xs uppercase text-slate-500">Custo total de manutenção</p><p class="text-slate-900">{{ 'R$ ' . number_format($equipamento->manutencoes->sum('custo'), 2, ',', '.') }}</p></div>
            </div>

            <div class="space-y-4 bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="font-medium text-slate-900">Histórico de manutenções</h3>

                <form method="POST" action="{{ route('equipamentos.manutencoes.store', $equipamento) }}" class="grid grid-cols-1 gap-3 rounded-md bg-slate-50/80 p-4 md:grid-cols-6">
                    @csrf
                    <x-field name="tipo" label="Tipo" type="select" required :blank="false" :options="['preventiva' => 'Preventiva', 'corretiva' => 'Corretiva']" />
                    <x-field name="data" label="Data" type="date" required :value="today()" />
                    <x-field name="custo" label="Custo (R$)" type="number" step="0.01" min="0" />
                    <x-field name="responsavel" label="Responsável" />
                    <x-field name="descricao" label="Descrição" span="2" />
                    <div class="md:col-span-6 flex justify-end"><button class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">Registrar manutenção</button></div>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50/80"><tr>
                            <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Data</th>
                            <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Tipo</th>
                            <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Responsável</th>
                            <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Descrição</th>
                            <th class="px-3 py-2 text-right text-xs font-medium uppercase text-slate-500">Custo</th>
                            <th></th></tr></thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($equipamento->manutencoes as $man)
                                <tr>
                                    <td class="px-3 py-2 text-slate-700">{{ $man->data?->format('d/m/Y') }}</td>
                                    <td class="px-3 py-2"><x-badge :value="$man->tipo" /></td>
                                    <td class="px-3 py-2 text-slate-700">{{ $man->responsavel }}</td>
                                    <td class="px-3 py-2 text-slate-700">{{ $man->descricao }}</td>
                                    <td class="px-3 py-2 text-right text-slate-700">{{ $man->custo !== null ? 'R$ ' . number_format($man->custo, 2, ',', '.') : '—' }}</td>
                                    <td class="px-3 py-2 text-right">
                                        <form method="POST" action="{{ route('manutencoes_equipamentos.destroy', $man) }}" onsubmit="return confirm('Remover esta manutenção?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline">Remover</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-3 py-6 text-center text-slate-500">Nenhuma manutenção registrada.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($equipamento->observacoes)
                <div class="bg-white p-6 text-sm shadow-sm sm:rounded-lg"><p class="text-xs uppercase text-slate-500">Observações</p><p class="whitespace-pre-line text-slate-700">{{ $equipamento->observacoes }}</p></div>
            @endif

            <a href="{{ route('equipamentos.index') }}" class="text-sm text-slate-600 hover:underline">← Voltar para a lista</a>
        </div>
    </div>
</x-app-layout>
