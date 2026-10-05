@php($m = $ordemProducao ?? null)
<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <x-field name="colaborador_responsavel_id" label="Responsável" type="select" :value="$m?->colaborador_responsavel_id" :options="$colaboradores->pluck('nome', 'id')" />
        <x-field name="equipamento_id" label="Equipamento" type="select" :value="$m?->equipamento_id" :options="$equipamentos->pluck('nome', 'id')" />
        <x-field name="prioridade" label="Prioridade" type="select" :value="$m?->prioridade ?? 'normal'" :options="['baixa' => 'Baixa', 'normal' => 'Normal', 'alta' => 'Alta', 'urgente' => 'Urgente']" required :blank="false" />
        <x-field name="status" label="Status" type="select" :value="$m?->status ?? 'fila'" :options="['fila' => 'Na fila', 'em_producao' => 'Em produção', 'acabamento' => 'Acabamento', 'finalizado' => 'Finalizado', 'entregue' => 'Entregue', 'cancelado' => 'Cancelado']" required :blank="false" />
        <x-field name="data_inicio_prevista" label="Início previsto" type="date" :value="$m?->data_inicio_prevista" />
        <x-field name="data_entrega_prevista" label="Entrega prevista" type="date" :value="$m?->data_entrega_prevista" />
        <x-field name="observacoes" label="Observações" type="textarea" :value="$m?->observacoes" span="3" />
</div>
