<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-wrap items-center justify-between gap-2">
            <h2 class="text-lg font-semibold text-slate-900">Orçamento {{ $orcamento->numero }}</h2>
            <div class="flex flex-wrap gap-2 print:hidden">
                <a href="{{ route('orcamentos.edit', $orcamento) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">Editar</a>
                <button type="button" onclick="window.print()" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">Imprimir</button>
                @if ($orcamento->status === 'aprovado')
                    @if ($orcamento->ordemProducao)
                        <a href="{{ route('ordens_producao.show', $orcamento->ordemProducao) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">Ver {{ $orcamento->ordemProducao->numero }}</a>
                    @else
                        <a href="{{ route('ordens_producao.create', ['orcamento_id' => $orcamento->id]) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">Gerar ordem de produção</a>
                    @endif
                    <a href="{{ route('contas_receber.create', ['orcamento_id' => $orcamento->id]) }}" class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">Gerar conta a receber</a>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="mx-auto max-w-5xl sm:px-6 lg:px-8">
            <x-flash />

            <div class="space-y-6 bg-white p-6 shadow-sm sm:rounded-lg">
                <div class="grid grid-cols-1 gap-4 text-sm md:grid-cols-3">
                    <div><p class="text-xs uppercase text-slate-500">Cliente</p><p class="font-medium text-slate-900">{{ $orcamento->cliente?->nome }}</p>
                        <p class="text-slate-600">{{ $orcamento->cliente?->telefone }}</p></div>
                    <div><p class="text-xs uppercase text-slate-500">Vendedor</p><p class="text-slate-900">{{ $orcamento->colaborador?->nome ?? '—' }}</p></div>
                    <div><p class="text-xs uppercase text-slate-500">Status</p><x-badge :value="$orcamento->status" /></div>
                    <div><p class="text-xs uppercase text-slate-500">Data</p><p class="text-slate-900">{{ $orcamento->data_orcamento?->format('d/m/Y') }}</p></div>
                    <div><p class="text-xs uppercase text-slate-500">Validade</p><p class="text-slate-900">{{ $orcamento->data_validade?->format('d/m/Y') ?? '—' }}</p></div>
                    <div><p class="text-xs uppercase text-slate-500">Forma de pagamento</p><p class="text-slate-900">{{ $orcamento->forma_pagamento ?? '—' }}</p></div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50/80">
                            <tr>
                                <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Item</th>
                                <th class="px-3 py-2 text-right text-xs font-medium uppercase text-slate-500">Medidas</th>
                                <th class="px-3 py-2 text-right text-xs font-medium uppercase text-slate-500">Qtd</th>
                                <th class="px-3 py-2 text-right text-xs font-medium uppercase text-slate-500">Unitário</th>
                                <th class="px-3 py-2 text-right text-xs font-medium uppercase text-slate-500">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-50">
                            @foreach ($orcamento->itens as $item)
                                <tr>
                                    <td class="px-3 py-2 text-slate-900">{{ $item->descricao }}
                                        @if ($item->observacoes)<span class="block text-xs text-slate-500">{{ $item->observacoes }}</span>@endif</td>
                                    <td class="px-3 py-2 text-right text-slate-600">
                                        @if ((float) $item->largura > 0 && (float) $item->altura > 0)
                                            {{ (float) $item->largura }} × {{ (float) $item->altura }} m
                                        @else — @endif
                                    </td>
                                    <td class="px-3 py-2 text-right text-slate-600">{{ (float) $item->quantidade }}</td>
                                    <td class="px-3 py-2 text-right text-slate-600">R$ {{ number_format($item->valor_unitario, 2, ',', '.') }}</td>
                                    <td class="px-3 py-2 text-right text-slate-900">R$ {{ number_format($item->valor_total, 2, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="ml-auto w-full max-w-xs space-y-1 text-sm">
                    <div class="flex justify-between text-slate-600"><span>Subtotal</span><span>R$ {{ number_format($orcamento->subtotal, 2, ',', '.') }}</span></div>
                    <div class="flex justify-between text-slate-600"><span>Desconto</span><span>− R$ {{ number_format($orcamento->valor_desconto, 2, ',', '.') }}</span></div>
                    <div class="flex justify-between text-slate-600"><span>Frete</span><span>R$ {{ number_format($orcamento->valor_frete, 2, ',', '.') }}</span></div>
                    <div class="flex justify-between border-t pt-2 text-base font-semibold text-slate-900"><span>Total</span><span>R$ {{ number_format($orcamento->valor_total, 2, ',', '.') }}</span></div>
                </div>

                @if ($orcamento->observacoes)
                    <div class="text-sm"><p class="text-xs uppercase text-slate-500">Observações</p><p class="whitespace-pre-line text-slate-700">{{ $orcamento->observacoes }}</p></div>
                @endif

                @if ($orcamento->contasReceber->isNotEmpty())
                    <div class="text-sm print:hidden">
                        <p class="mb-1 text-xs uppercase text-slate-500">Contas a receber vinculadas</p>
                        <ul class="space-y-1">
                            @foreach ($orcamento->contasReceber as $cr)
                                <li><a href="{{ route('contas_receber.edit', $cr) }}" class="text-indigo-600 hover:underline">{{ $cr->descricao }}</a>
                                    — R$ {{ number_format($cr->valor, 2, ',', '.') }} <x-badge :value="$cr->status_efetivo" /></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="mt-4 print:hidden"><a href="{{ route('orcamentos.index') }}" class="text-sm text-slate-600 hover:underline">← Voltar para a lista</a></div>
        </div>
    </div>
</x-app-layout>
