@php($m = $orcamento ?? null)
<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <x-field name="cliente_id" label="Cliente" type="select" :value="$m?->cliente_id" :options="$clientes->pluck('nome', 'id')" required span="2" />
        <x-field name="colaborador_id" label="Vendedor responsável" type="select" :value="$m?->colaborador_id ?? $colaboradorLogado" :options="$colaboradores->pluck('nome', 'id')" />
        <x-field name="data_orcamento" label="Data do orçamento" type="date" :value="$m?->data_orcamento ?? today()" required />
        <x-field name="data_validade" label="Validade" type="date" :value="$m?->data_validade ?? today()->addDays(15)" />
        <x-field name="status" label="Status" type="select" :value="$m?->status ?? 'pendente'" :options="['pendente' => 'Pendente', 'aprovado' => 'Aprovado', 'reprovado' => 'Reprovado', 'expirado' => 'Expirado', 'cancelado' => 'Cancelado']" required :blank="false" />
        <x-field name="forma_pagamento" label="Forma de pagamento" type="select" :value="$m?->forma_pagamento" :options="['Dinheiro' => 'Dinheiro', 'PIX' => 'PIX', 'Boleto' => 'Boleto', 'Cartão de crédito' => 'Cartão de crédito', 'Cartão de débito' => 'Cartão de débito', 'Transferência' => 'Transferência', 'Cheque' => 'Cheque']" />
        <x-field name="observacoes" label="Observações" type="textarea" :value="$m?->observacoes" span="3" />
</div>
