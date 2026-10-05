@php($m = $categoriaFinanceira ?? null)
<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <x-field name="nome" label="Nome" :value="$m?->nome" required span="2" />
        <x-field name="tipo" label="Tipo" type="select" :value="$m?->tipo" :options="['receita' => 'Receita', 'despesa' => 'Despesa']" required :blank="false" />
</div>
