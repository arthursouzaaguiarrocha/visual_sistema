@php($m = $produto ?? null)
<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <x-field name="nome" label="Nome" :value="$m?->nome" required span="2" />
        <x-field name="categoria" label="Categoria" :value="$m?->categoria" placeholder="banner, adesivo, placa, fachada..." />
        <x-field name="unidade_medida" label="Unidade de medida" type="select" :value="$m?->unidade_medida" :options="['m2' => 'm²', 'un' => 'un', 'ml' => 'ml']" required :blank="false" />
        <x-field name="preco_base" label="Preço base (R$)" type="number" :value="$m?->preco_base ?? 0" required step="0.01" min="0" />
        <x-field name="margem_lucro" label="Margem de lucro (%)" type="number" :value="$m?->margem_lucro" step="0.01" min="0" />
        <x-field name="tempo_producao_estimado_horas" label="Tempo de produção (horas)" type="number" :value="$m?->tempo_producao_estimado_horas" step="0.01" min="0" />
        <x-field name="descricao" label="Descrição" type="textarea" :value="$m?->descricao" span="3" />
        <x-field name="ativo" label="Ativo" type="checkbox" :value="$m?->ativo ?? true" />
</div>
