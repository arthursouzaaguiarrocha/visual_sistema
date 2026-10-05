<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-xl font-semibold leading-tight text-slate-900">{{ $veiculo->placa }} — {{ $veiculo->marca }} {{ $veiculo->modelo }}</h2>
            <a href="{{ route('veiculos.edit', $veiculo) }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">Editar</a>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="mx-auto max-w-5xl space-y-6 sm:px-6 lg:px-8">
            <x-flash />

            <div class="grid grid-cols-2 gap-4 bg-white p-6 text-sm shadow-sm sm:rounded-lg md:grid-cols-4">
                <div><p class="text-xs uppercase text-slate-500">Tipo</p><p class="text-slate-900">{{ $veiculo->tipo ?? '—' }}</p></div>
                <div><p class="text-xs uppercase text-slate-500">Ano</p><p class="text-slate-900">{{ ($veiculo->ano_fabricacao ?? '—') . '/' . ($veiculo->ano_modelo ?? '—') }}</p></div>
                <div><p class="text-xs uppercase text-slate-500">KM atual</p><p class="text-slate-900">{{ number_format($veiculo->km_atual, 0, ',', '.') }}</p></div>
                <div><p class="text-xs uppercase text-slate-500">Status</p><x-badge :value="$veiculo->status" /></div>
                <div><p class="text-xs uppercase text-slate-500">Aquisição</p><p class="text-slate-900">{{ $veiculo->data_aquisicao?->format('d/m/Y') ?? '—' }}</p></div>
                <div><p class="text-xs uppercase text-slate-500">Valor de aquisição</p><p class="text-slate-900">{{ $veiculo->valor_aquisicao ? 'R$ ' . number_format($veiculo->valor_aquisicao, 2, ',', '.') : '—' }}</p></div>
                <div><p class="text-xs uppercase text-slate-500">Gasto com manutenção</p><p class="text-slate-900">{{ 'R$ ' . number_format($veiculo->manutencoes->sum('custo'), 2, ',', '.') }}</p></div>
                <div><p class="text-xs uppercase text-slate-500">Gasto com combustível</p><p class="text-slate-900">{{ 'R$ ' . number_format($veiculo->abastecimentos->sum('valor_total'), 2, ',', '.') }}</p></div>
            </div>

            {{-- Manutenções --}}
            <div class="space-y-4 bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="font-medium text-slate-900">Manutenções</h3>

                <form method="POST" action="{{ route('veiculos.manutencoes.store', $veiculo) }}" class="grid grid-cols-1 gap-3 rounded-md bg-slate-50/80 p-4 md:grid-cols-5">
                    @csrf
                    <x-field name="tipo" label="Tipo" type="select" required :blank="false" :options="['preventiva' => 'Preventiva', 'corretiva' => 'Corretiva']" />
                    <x-field name="data" label="Data" type="date" required :value="today()" />
                    <x-field name="km_atual" label="KM" type="number" step="1" min="0" />
                    <x-field name="custo" label="Custo (R$)" type="number" step="0.01" min="0" />
                    <x-field name="descricao" label="Descrição" />
                    <div class="md:col-span-5 flex justify-end"><button class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500">Registrar manutenção</button></div>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50/80"><tr>
                            <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Data</th>
                            <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Tipo</th>
                            <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">KM</th>
                            <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Descrição</th>
                            <th class="px-3 py-2 text-right text-xs font-medium uppercase text-slate-500">Custo</th>
                            <th></th></tr></thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($veiculo->manutencoes as $man)
                                <tr>
                                    <td class="px-3 py-2 text-slate-700">{{ $man->data?->format('d/m/Y') }}</td>
                                    <td class="px-3 py-2"><x-badge :value="$man->tipo" /></td>
                                    <td class="px-3 py-2 text-slate-700">{{ $man->km_atual !== null ? number_format($man->km_atual, 0, ',', '.') : '—' }}</td>
                                    <td class="px-3 py-2 text-slate-700">{{ $man->descricao }}</td>
                                    <td class="px-3 py-2 text-right text-slate-700">{{ $man->custo !== null ? 'R$ ' . number_format($man->custo, 2, ',', '.') : '—' }}</td>
                                    <td class="px-3 py-2 text-right">
                                        <form method="POST" action="{{ route('manutencoes_veiculos.destroy', $man) }}" onsubmit="return confirm('Remover esta manutenção?')">
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

            {{-- Abastecimentos --}}
            <div class="space-y-4 bg-white p-6 shadow-sm sm:rounded-lg">
                <h3 class="font-medium text-slate-900">Abastecimentos</h3>

                <form method="POST" action="{{ route('veiculos.abastecimentos.store', $veiculo) }}"
                    x-data="{ litros: '', valorLitro: '', total: '', calc() { if (this.litros && this.valorLitro) this.total = (this.litros * this.valorLitro).toFixed(2); } }"
                    class="grid grid-cols-1 gap-3 rounded-md bg-slate-50/80 p-4 md:grid-cols-4">
                    @csrf
                    <x-field name="data" label="Data" type="date" required :value="today()" />
                    <x-field name="km_atual" label="KM" type="number" step="1" min="0" />
                    <x-field name="litros" label="Litros" type="number" step="0.01" min="0" x-model="litros" @input="calc()" />
                    <x-field name="valor_litro" label="Valor por litro (R$)" type="number" step="0.001" min="0" x-model="valorLitro" @input="calc()" />
                    <x-field name="valor_total" label="Valor total (R$)" type="number" step="0.01" min="0" required x-model="total" />
                    <x-field name="posto" label="Posto" />
                    <x-field name="colaborador_id" label="Motorista" type="select" :options="$colaboradores->pluck('nome', 'id')" />
                    <div class="flex items-end justify-end"><button class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500">Registrar abastecimento</button></div>
                </form>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-100 text-sm">
                        <thead class="bg-slate-50/80"><tr>
                            <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Data</th>
                            <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">KM</th>
                            <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Litros</th>
                            <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Posto</th>
                            <th class="px-3 py-2 text-left text-xs font-medium uppercase text-slate-500">Motorista</th>
                            <th class="px-3 py-2 text-right text-xs font-medium uppercase text-slate-500">Total</th>
                            <th></th></tr></thead>
                        <tbody class="divide-y divide-slate-50">
                            @forelse ($veiculo->abastecimentos as $ab)
                                <tr>
                                    <td class="px-3 py-2 text-slate-700">{{ $ab->data?->format('d/m/Y') }}</td>
                                    <td class="px-3 py-2 text-slate-700">{{ $ab->km_atual !== null ? number_format($ab->km_atual, 0, ',', '.') : '—' }}</td>
                                    <td class="px-3 py-2 text-slate-700">{{ $ab->litros !== null ? number_format($ab->litros, 2, ',', '.') : '—' }}</td>
                                    <td class="px-3 py-2 text-slate-700">{{ $ab->posto }}</td>
                                    <td class="px-3 py-2 text-slate-700">{{ $ab->colaborador?->nome }}</td>
                                    <td class="px-3 py-2 text-right text-slate-700">R$ {{ number_format($ab->valor_total, 2, ',', '.') }}</td>
                                    <td class="px-3 py-2 text-right">
                                        <form method="POST" action="{{ route('abastecimentos_veiculos.destroy', $ab) }}" onsubmit="return confirm('Remover este abastecimento?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 hover:underline">Remover</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" class="px-3 py-6 text-center text-slate-500">Nenhum abastecimento registrado.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($veiculo->observacoes)
                <div class="bg-white p-6 text-sm shadow-sm sm:rounded-lg"><p class="text-xs uppercase text-slate-500">Observações</p><p class="whitespace-pre-line text-slate-700">{{ $veiculo->observacoes }}</p></div>
            @endif

            <a href="{{ route('veiculos.index') }}" class="text-sm text-slate-600 hover:underline">← Voltar para a lista</a>
        </div>
    </div>
</x-app-layout>
