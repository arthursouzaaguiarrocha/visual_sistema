@php($m = $materia ?? null)
<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <x-field name="nome" label="Nome" :value="$m?->nome" required span="2" />
        <x-field name="fornecedor_id" label="Fornecedor" type="select" :value="$m?->fornecedor_id" :options="$fornecedores->pluck('nome', 'id')" />
        <x-field name="unidade_medida" label="Unidade de medida" type="select" :value="$m?->unidade_medida" :options="['m' => 'm', 'm2' => 'm²', 'un' => 'un', 'kg' => 'kg', 'rolo' => 'rolo', 'litro' => 'litro']" required :blank="false" />
        <x-field name="quantidade_estoque" label="Quantidade em estoque" type="number" :value="$m?->quantidade_estoque ?? 0" required step="0.001" min="0" />
        <x-field name="estoque_minimo" label="Estoque mínimo" type="number" :value="$m?->estoque_minimo ?? 0" required step="0.001" min="0" />
        <x-field name="preco_custo" label="Preço de custo (R$)" type="number" :value="$m?->preco_custo ?? 0" required step="0.01" min="0" />
        <x-field name="localizacao_estoque" label="Localização no estoque" :value="$m?->localizacao_estoque" span="2" />
        <x-field name="descricao" label="Descrição" type="textarea" :value="$m?->descricao" span="3" />
        <x-field name="ativo" label="Ativo" type="checkbox" :value="$m?->ativo ?? true" />
</div>
