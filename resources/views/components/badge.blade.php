@props(['value'])

@php
    $cores = [
        'ativo' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'aprovado' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'pago' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'recebido' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'finalizado' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'entregue' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'concluido' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'entrada' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'receita' => 'bg-emerald-50 text-emerald-700 ring-emerald-600/20',
        'pendente' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        'manutencao' => 'bg-amber-50 text-amber-700 ring-amber-600/20',
        'em_producao' => 'bg-sky-50 text-sky-700 ring-sky-600/20',
        'preventiva' => 'bg-sky-50 text-sky-700 ring-sky-600/20',
        'acabamento' => 'bg-violet-50 text-violet-700 ring-violet-600/20',
        'alta' => 'bg-orange-50 text-orange-700 ring-orange-600/20',
        'corretiva' => 'bg-orange-50 text-orange-700 ring-orange-600/20',
        'urgente' => 'bg-red-50 text-red-700 ring-red-600/20',
        'atrasado' => 'bg-red-50 text-red-700 ring-red-600/20',
        'reprovado' => 'bg-red-50 text-red-700 ring-red-600/20',
        'cancelado' => 'bg-red-50 text-red-700 ring-red-600/20',
        'inativo' => 'bg-red-50 text-red-700 ring-red-600/20',
        'saida' => 'bg-red-50 text-red-700 ring-red-600/20',
        'despesa' => 'bg-red-50 text-red-700 ring-red-600/20',
    ];
    $classe = $cores[$value] ?? 'bg-slate-50 text-slate-600 ring-slate-500/15';
@endphp

<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-medium ring-1 ring-inset {{ $classe }}">{{ ucfirst(str_replace('_', ' ', (string) $value)) }}</span>
