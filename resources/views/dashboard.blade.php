<x-app-layout>
    <x-slot name="header">
        <div>
            <h1 class="text-lg font-semibold text-slate-900">Dashboard</h1>
            <p class="text-sm text-slate-500">Visão geral do negócio</p>
        </div>
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="mx-auto max-w-7xl space-y-6">
            <x-flash />

            {{-- KPI cards --}}
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
                <a href="{{ route('contas_receber.index', ['status' => 'pendente']) }}"
                   class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">A receber</p>
                            <p class="mt-2 text-2xl font-bold tracking-tight text-slate-900">R$ {{ number_format($totalReceber, 2, ',', '.') }}</p>
                            @if ($receberVencidas)
                                <p class="mt-1.5 text-xs font-medium text-red-600">{{ $receberVencidas }} vencida(s)</p>
                            @else
                                <p class="mt-1.5 text-xs text-slate-400">em aberto</p>
                            @endif
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('contas_pagar.index', ['status' => 'pendente']) }}"
                   class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">A pagar</p>
                            <p class="mt-2 text-2xl font-bold tracking-tight text-slate-900">R$ {{ number_format($totalPagar, 2, ',', '.') }}</p>
                            @if ($pagarVencidas)
                                <p class="mt-1.5 text-xs font-medium text-red-600">{{ $pagarVencidas }} vencida(s)</p>
                            @else
                                <p class="mt-1.5 text-xs text-slate-400">em aberto</p>
                            @endif
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('fluxo_caixa.index', ['de' => today()->startOfMonth()->toDateString(), 'ate' => today()->endOfMonth()->toDateString()]) }}"
                   class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Saldo do mês</p>
                            <p class="mt-2 text-2xl font-bold tracking-tight {{ $saldoMes < 0 ? 'text-red-600' : 'text-emerald-600' }}">
                                R$ {{ number_format($saldoMes, 2, ',', '.') }}
                            </p>
                            <p class="mt-1.5 text-xs text-slate-400">entradas − saídas</p>
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-indigo-50 text-indigo-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                        </div>
                    </div>
                </a>

                <a href="{{ route('materias_primas.index') }}"
                   class="group relative overflow-hidden rounded-2xl border border-slate-200/80 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:shadow-md">
                    <div class="flex items-start justify-between">
                        <div>
                            <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Estoque baixo</p>
                            <p class="mt-2 text-2xl font-bold tracking-tight {{ $estoqueBaixo ? 'text-red-600' : 'text-slate-900' }}">{{ $estoqueBaixo }}</p>
                            <p class="mt-1.5 text-xs text-slate-400">matérias-primas</p>
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-rose-50 text-rose-600">
                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                        </div>
                    </div>
                </a>
            </div>

            <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">
                {{-- Próximas entregas --}}
                <div class="rounded-2xl border border-slate-200/80 bg-white shadow-sm lg:col-span-2">
                    <div class="flex items-center justify-between border-b border-slate-100 px-5 py-4">
                        <div>
                            <h2 class="font-semibold text-slate-900">Próximas entregas</h2>
                            <p class="text-xs text-slate-500">{{ $ordensAbertas }} ordem(ns) · {{ $orcamentosPendentes }} orçamento(s) pendente(s)</p>
                        </div>
                        <a href="{{ route('ordens_producao.index') }}" class="text-sm font-medium text-indigo-600 hover:text-indigo-500">Ver todas</a>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @forelse ($proximasEntregas as $op)
                            <a href="{{ route('ordens_producao.show', $op) }}"
                               class="flex items-center gap-4 px-5 py-3.5 transition hover:bg-slate-50/80">
                                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-slate-100 text-xs font-semibold text-slate-600">
                                    {{ strtoupper(substr($op->numero, -2)) }}
                                </div>
                                <div class="min-w-0 flex-1">
                                    <p class="truncate text-sm font-medium text-slate-900">{{ $op->numero }} · {{ $op->orcamento?->cliente?->nome }}</p>
                                    <p class="text-xs text-slate-500">{{ $op->data_entrega_prevista?->format('d/m/Y') ?? 'sem data' }}</p>
                                </div>
                                <x-badge :value="$op->status" />
                            </a>
                        @empty
                            <p class="px-5 py-10 text-center text-sm text-slate-400">Nenhuma ordem em aberto.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Atalhos --}}
                <div class="rounded-2xl border border-slate-200/80 bg-white shadow-sm">
                    <div class="border-b border-slate-100 px-5 py-4">
                        <h2 class="font-semibold text-slate-900">Atalhos</h2>
                        <p class="text-xs text-slate-500">Ações rápidas</p>
                    </div>
                    <div class="space-y-1 p-3">
                        @foreach ([
                            ['orcamentos.create', 'Novo orçamento', 'M2 5a2 2 0 012-2h10a2 2 0 012 2v14l-7-3.5L2 19V5z'],
                            ['ordens_producao.create', 'Nova ordem de produção', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
                            ['clientes.create', 'Novo cliente', 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z'],
                            ['contas_receber.create', 'Nova conta a receber', 'M12 4v16m8-8H4'],
                            ['contas_pagar.create', 'Nova conta a pagar', 'M20 12H4'],
                        ] as [$route, $label, $icon])
                            <a href="{{ route($route) }}"
                               class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm text-slate-700 transition hover:bg-indigo-50 hover:text-indigo-700">
                                <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-slate-100 text-slate-500">
                                    <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.75"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
                                </span>
                                {{ $label }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Módulos --}}
            <div class="grid grid-cols-2 gap-4 sm:grid-cols-3 lg:grid-cols-5">
                @foreach (config('modulos') as $grupo => $itens)
                    <div class="rounded-2xl border border-slate-200/80 bg-white p-4 shadow-sm">
                        <h3 class="mb-2.5 text-[11px] font-semibold uppercase tracking-wider text-slate-400">{{ $grupo }}</h3>
                        <ul class="space-y-1">
                            @foreach ($itens as [$rotulo, $prefixo])
                                <li>
                                    <a href="{{ route($prefixo . '.index') }}"
                                       class="block rounded-lg px-2 py-1.5 text-sm text-slate-700 transition hover:bg-slate-50 hover:text-indigo-600">
                                        {{ $rotulo }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
