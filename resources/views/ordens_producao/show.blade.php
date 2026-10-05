<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-2">
            <h2 class="text-lg font-semibold text-slate-900">Ordem de produção {{ $ordemProducao->numero }}</h2>
            <div class="flex gap-2 print:hidden">
                <a href="{{ route('ordens_producao.edit', $ordemProducao) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">Atualizar andamento</a>
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">Imprimir</button>
            </div>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
            <x-flash />

            <div class="space-y-6 bg-white p-6 shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-4">
                    <div><p class="text-xs uppercase text-slate-500">Orçamento</p>
                        <a href="{{ route('orcamentos.show', $ordemProducao->orcamento) }}" class="text-indigo-600 hover:underline">{{ $ordemProducao->orcamento->numero }}</a></div>
                    <div><p class="text-xs uppercase text-slate-500">Cliente</p><p class="text-slate-900">{{ $ordemProducao->orcamento->cliente?->nome }}</p></div>
                    <div><p class="text-xs uppercase text-slate-500">Status</p><x-badge :value="$ordemProducao->status" /></div>
                    <div><p class="text-xs uppercase text-slate-500">Prioridade</p><x-badge :value="$ordemProducao->prioridade" /></div>
                    <div><p class="text-xs uppercase text-slate-500">Responsável</p><p class="text-slate-900">{{ $ordemProducao->responsavel?->nome ?? '—' }}</p></div>
                    <div><p class="text-xs uppercase text-slate-500">Equipamento</p><p class="text-slate-900">{{ $ordemProducao->equipamento?->nome ?? '—' }}</p></div>
                    <div><p class="text-xs uppercase text-slate-500">Início previsto</p><p class="text-slate-900">{{ $ordemProducao->data_inicio_prevista?->format('d/m/Y') ?? '—' }}</p></div>
                    <div><p class="text-xs uppercase text-slate-500">Entrega prevista</p><p class="text-slate-900">{{ $ordemProducao->data_entrega_prevista?->format('d/m/Y') ?? '—' }}</p></div>
                    <div><p class="text-xs uppercase text-slate-500">Início real</p><p class="text-slate-900">{{ $ordemProducao->data_inicio_real?->format('d/m/Y H:i') ?? '—' }}</p></div>
                    <div><p class="text-xs uppercase text-slate-500">Conclusão real</p><p class="text-slate-900">{{ $ordemProducao->data_conclusao_real?->format('d/m/Y H:i') ?? '—' }}</p></div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Item</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Medidas / Qtd</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Responsável</th>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Status</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach ($ordemProducao->itens as $it)
                                @php $oi = $it->orcamentoItem; @endphp
                                <tr>
                                    <td class="px-3 py-2 text-slate-900">{{ $oi?->descricao }}
                                        @if ($it->observacoes)<span class="block text-xs text-slate-500">{{ $it->observacoes }}</span>@endif</td>
                                    <td class="px-3 py-2 text-slate-600">
                                        @if ((float) $oi?->largura > 0 && (float) $oi?->altura > 0) {{ (float) $oi->largura }} × {{ (float) $oi->altura }} m · @endif
                                        Qtd {{ (float) $oi?->quantidade }}
                                    </td>
                                    <td class="px-3 py-2 text-slate-600">{{ $it->colaborador?->nome ?? '—' }}</td>
                                    <td class="px-3 py-2"><x-badge :value="$it->status" /></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                @if ($ordemProducao->observacoes)
                    <div class="text-sm"><p class="text-xs uppercase text-slate-500">Observações</p><p class="whitespace-pre-line text-slate-700">{{ $ordemProducao->observacoes }}</p></div>
                @endif
            </div>

            <div class="mt-4 print:hidden"><a href="{{ route('ordens_producao.index') }}" class="text-sm text-slate-600 hover:underline">← Voltar para a lista</a></div>
        </div>
    </div>
</x-app-layout>
