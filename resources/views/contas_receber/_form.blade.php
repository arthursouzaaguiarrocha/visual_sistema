@php($m = $contaReceber ?? null)
<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <x-field name="cliente_id" label="Cliente" type="select" :value="$m?->cliente_id" :options="$clientes->pluck('nome', 'id')" required span="2" />
        <x-field name="orcamento_id" label="Orçamento" type="select" :value="$m?->orcamento_id" :options="$orcamentos" />
        <x-field name="categoria_financeira_id" label="Categoria" type="select" :value="$m?->categoria_financeira_id" :options="$categorias->pluck('nome', 'id')" />
        <x-field name="descricao" label="Descrição" :value="$m?->descricao" required span="2" />
        <x-field name="valor" label="Valor (R$)" type="number" :value="$m?->valor" required step="0.01" min="0.01" />
        <x-field name="data_emissao" label="Emissão" type="date" :value="$m?->data_emissao" />
        <x-field name="data_vencimento" label="Vencimento" type="date" :value="$m?->data_vencimento" required />
        <x-field name="forma_pagamento" label="Forma de pagamento" type="select" :value="$m?->forma_pagamento" :options="['Dinheiro' => 'Dinheiro', 'PIX' => 'PIX', 'Boleto' => 'Boleto', 'Cartão de crédito' => 'Cartão de crédito', 'Cartão de débito' => 'Cartão de débito', 'Transferência' => 'Transferência', 'Cheque' => 'Cheque']" />
        <x-field name="numero_documento" label="Nº do documento" :value="$m?->numero_documento" />
        @if ($m?->status !== 'recebido')
            <x-field name="status" label="Status" type="select" :value="$m?->status ?? 'pendente'" :options="['pendente' => 'Pendente', 'cancelado' => 'Cancelado']" :blank="false" />
        @endif
        <x-field name="observacoes" label="Observações" type="textarea" :value="$m?->observacoes" span="3" />
</div>
