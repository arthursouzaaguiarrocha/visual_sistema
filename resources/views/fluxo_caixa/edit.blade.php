<x-app-layout>
    <x-slot name="header">
        <h2 class="text-lg font-semibold text-slate-900">Editar Movimentação</h2>
    </x-slot>

    <div class="p-4 sm:p-6 lg:p-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <x-flash />

            <form method="POST" action="{{ route('fluxo_caixa.update', $movimento) }}" class="space-y-6 bg-white p-6 shadow-sm sm:rounded-lg">
                @csrf
                @method('PUT')
                @include('fluxo_caixa._form')
                <div class="flex justify-end gap-3">
                    <a href="{{ route('fluxo_caixa.index') }}" class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-700 shadow-sm transition hover:bg-slate-50">Cancelar</a>
                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm transition hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30">Salvar alterações</button>
                </div>
            </form>

        </div>
    </div>
</x-app-layout>
