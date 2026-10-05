@php($m = $movimento ?? null)
<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <x-field name="tipo" label="Tipo" type="select" :value="$m?->tipo" :options="['entrada' => 'Entrada', 'saida' => 'Saída']" required :blank="false" />
        <x-field name="data_movimento" label="Data" type="date" :value="$m?->data_movimento ?? today()" required />
        <x-field name="valor" label="Valor (R$)" type="number" :value="$m?->valor" required step="0.01" min="0.01" />
        <x-field name="descricao" label="Descrição" :value="$m?->descricao" required span="2" />
        <x-field name="categoria_financeira_id" label="Categoria" type="select" :value="$m?->categoria_financeira_id" :options="$categorias" />
        <x-field name="forma_pagamento" label="Forma de pagamento" type="select" :value="$m?->forma_pagamento" :options="['Dinheiro' => 'Dinheiro', 'PIX' => 'PIX', 'Boleto' => 'Boleto', 'Cartão de crédito' => 'Cartão de crédito', 'Cartão de débito' => 'Cartão de débito', 'Transferência' => 'Transferência', 'Cheque' => 'Cheque']" />
        <x-field name="observacoes" label="Observações" type="textarea" :value="$m?->observacoes" span="3" />
</div>
