@php($m = $equipamento ?? null)
<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <x-field name="nome" label="Nome" :value="$m?->nome" required span="2" />
        <x-field name="tipo" label="Tipo" :value="$m?->tipo" placeholder="impressora, plotter, laser, CNC..." />
        <x-field name="marca" label="Marca" :value="$m?->marca" />
        <x-field name="modelo" label="Modelo" :value="$m?->modelo" />
        <x-field name="numero_serie" label="Número de série" :value="$m?->numero_serie" />
        <x-field name="data_aquisicao" label="Data de aquisição" type="date" :value="$m?->data_aquisicao" />
        <x-field name="valor_aquisicao" label="Valor de aquisição (R$)" type="number" :value="$m?->valor_aquisicao" step="0.01" min="0" />
        <x-field name="status" label="Status" type="select" :value="$m?->status ?? 'ativo'" :options="['ativo' => 'Ativo', 'manutencao' => 'Em manutenção', 'inativo' => 'Inativo']" required :blank="false" />
        <x-field name="localizacao" label="Localização" :value="$m?->localizacao" />
        <x-field name="observacoes" label="Observações" type="textarea" :value="$m?->observacoes" span="3" />
</div>
