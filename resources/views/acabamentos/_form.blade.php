@php($m = $acabamento ?? null)
<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <x-field name="nome" label="Nome" :value="$m?->nome" required span="2" />
        <x-field name="unidade_medida" label="Unidade de medida" type="select" :value="$m?->unidade_medida" :options="['un' => 'un', 'm' => 'm', 'm2' => 'm²']" />
        <x-field name="preco" label="Preço (R$)" type="number" :value="$m?->preco ?? 0" required step="0.01" min="0" />
        <x-field name="descricao" label="Descrição" type="textarea" :value="$m?->descricao" span="2" />
        <x-field name="ativo" label="Ativo" type="checkbox" :value="$m?->ativo ?? true" />
</div>
