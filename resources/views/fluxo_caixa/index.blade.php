<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="text-lg font-semibold text-slate-900">Fluxo de caixa</h2>
            <a href="{{ route('fluxo_caixa.create') }}" class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">+ Movimentação</a>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
            <x-flash />

            <div class="mb-4 grid grid-cols-1 gap-4 sm:grid-cols-3">
                <div class="rounded-lg bg-white p-4 shadow-sm"><p class="text-xs uppercase text-slate-500">Entradas</p><p class="text-xl font-semibold text-green-700">R$ {{ number_format($entradas, 2, ',', '.') }}</p></div>
                <div class="rounded-lg bg-white p-4 shadow-sm"><p class="text-xs uppercase text-slate-500">Saídas</p><p class="text-xl font-semibold text-red-600">R$ {{ number_format($saidas, 2, ',', '.') }}</p></div>
                <div class="rounded-lg bg-white p-4 shadow-sm"><p class="text-xs uppercase text-slate-500">Saldo do período filtrado</p>
                    <p class="text-xl font-semibold {{ $entradas - $saidas < 0 ? 'text-red-600' : 'text-slate-900' }}">R$ {{ number_format($entradas - $saidas, 2, ',', '.') }}</p></div>
            </div>

            <form method="GET" class="mb-4 flex flex-wrap items-end gap-3">
                <div><label class="block text-xs font-medium text-slate-500">Buscar</label><input type="text" name="q" value="{{ request('q') }}" class="mt-1 rounded-md border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                <div><label class="block text-xs font-medium text-slate-500">Tipo</label>
                    <select name="tipo" class="mt-1 rounded-md border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"><option value="">Todos</option>
                        <option value="entrada" @selected(request('tipo') === 'entrada')>Entrada</option>
                        <option value="saida" @selected(request('tipo') === 'saida')>Saída</option></select></div>
                <div><label class="block text-xs font-medium text-slate-500">Categoria</label>
                    <select name="categoria" class="mt-1 rounded-md border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"><option value="">Todas</option>
                        @foreach ($categorias as $c)<option value="{{ $c->id }}" @selected((string) request('categoria') === (string) $c->id)>{{ $c->nome }}</option>@endforeach</select></div>
                <div><label class="block text-xs font-medium text-slate-500">De</label><input type="date" name="de" value="{{ request('de') }}" class="mt-1 rounded-md border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                <div><label class="block text-xs font-medium text-slate-500">Até</label><input type="date" name="ate" value="{{ request('ate') }}" class="mt-1 rounded-md border-slate-200 text-sm shadow-sm focus:border-indigo-500 focus:ring-indigo-500"></div>
                <button class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">Filtrar</button>
                @if (request()->query())<a href="{{ url()->current() }}" class="text-sm text-slate-600 underline">Limpar</a>@endif
            </form>

            <div class="overflow-x-auto rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                <table class="min-w-full divide-y divide-slate-100 text-sm">
                    <thead class="bg-slate-50/80">
                        <tr>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Data</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Descrição</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Categoria</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Origem</th>
                            <th class="px-4 py-3 text-left text-xs font-medium uppercase text-slate-500">Tipo</th>
                            <th class="px-4 py-3 text-right text-xs font-medium uppercase text-slate-500">Valor</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse ($movimentos as $mov)
                            <tr class="hover:bg-slate-50/80">
                                <td class="px-4 py-3 text-slate-700">{{ $mov->data_movimento?->format('d/m/Y') }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $mov->descricao }}</td>
                                <td class="px-4 py-3 text-slate-700">{{ $mov->categoria?->nome }}</td>
                                <td class="px-4 py-3 text-slate-700">
                                    @if ($mov->contaPagar)<a href="{{ route('contas_pagar.edit', $mov->contaPagar) }}" class="text-indigo-600 hover:underline">Conta a pagar</a>
                                    @elseif ($mov->contaReceber)<a href="{{ route('contas_receber.edit', $mov->contaReceber) }}" class="text-indigo-600 hover:underline">Conta a receber</a>
                                    @else Manual @endif
                                </td>
                                <td class="px-4 py-3"><x-badge :value="$mov->tipo" /></td>
                                <td class="whitespace-nowrap px-4 py-3 text-right font-medium {{ $mov->tipo === 'entrada' ? 'text-green-700' : 'text-red-600' }}">
                                    {{ $mov->tipo === 'entrada' ? '+' : '−' }} R$ {{ number_format($mov->valor, 2, ',', '.') }}</td>
                                <td class="whitespace-nowrap px-4 py-3 text-right">
                                    <a href="{{ route('fluxo_caixa.edit', $mov) }}" class="mr-3 text-indigo-600 hover:underline">Editar</a>
                                    <form method="POST" action="{{ route('fluxo_caixa.destroy', $mov) }}" class="inline" onsubmit="return confirm('Excluir esta movimentação?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 hover:underline">Excluir</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="7" class="px-4 py-8 text-center text-slate-500">Nenhuma movimentação encontrada.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">{{ $movimentos->links() }}</div>
        </div>
    </div>
</x-app-layout>
