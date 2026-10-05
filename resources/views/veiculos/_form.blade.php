@php($m = $veiculo ?? null)
<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <x-field name="placa" label="Placa" :value="$m?->placa" required class="uppercase" />
        <x-field name="marca" label="Marca" :value="$m?->marca" required />
        <x-field name="modelo" label="Modelo" :value="$m?->modelo" required />
        <x-field name="ano_fabricacao" label="Ano de fabricação" type="number" :value="$m?->ano_fabricacao" step="1" />
        <x-field name="ano_modelo" label="Ano do modelo" type="number" :value="$m?->ano_modelo" step="1" />
        <x-field name="tipo" label="Tipo" type="select" :value="$m?->tipo" :options="['Moto' => 'Moto', 'Carro' => 'Carro', 'Van' => 'Van', 'Caminhão' => 'Caminhão', 'Outro' => 'Outro']" />
        <x-field name="status" label="Status" type="select" :value="$m?->status ?? 'ativo'" :options="['ativo' => 'Ativo', 'manutencao' => 'Em manutenção', 'inativo' => 'Inativo']" required :blank="false" />
        <x-field name="km_atual" label="KM atual" type="number" :value="$m?->km_atual ?? 0" step="1" min="0" />
        <x-field name="data_aquisicao" label="Data de aquisição" type="date" :value="$m?->data_aquisicao" />
        <x-field name="valor_aquisicao" label="Valor de aquisição (R$)" type="number" :value="$m?->valor_aquisicao" step="0.01" min="0" />
        <x-field name="observacoes" label="Observações" type="textarea" :value="$m?->observacoes" span="3" />
</div>
