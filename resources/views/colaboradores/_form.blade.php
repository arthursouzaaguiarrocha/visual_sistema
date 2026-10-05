@php($m = $colaborador ?? null)
<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <x-field name="nome" label="Nome" :value="$m?->nome" required span="2" />
        <x-field name="cpf" label="CPF" :value="$m?->cpf" maxlength="14" />
        <x-field name="cargo" label="Cargo" :value="$m?->cargo" />
        <x-field name="setor" label="Setor" :value="$m?->setor" />
        <x-field name="salario" label="Salário (R$)" type="number" :value="$m?->salario" step="0.01" min="0" />
        <x-field name="data_admissao" label="Data de admissão" type="date" :value="$m?->data_admissao" />
        <x-field name="data_demissao" label="Data de demissão" type="date" :value="$m?->data_demissao" />
        <x-field name="telefone" label="Telefone" type="tel" :value="$m?->telefone" />
        <x-field name="email" label="E-mail" type="email" :value="$m?->email" />
        <x-field name="user_id" label="Usuário de acesso ao sistema" type="select" :value="$m?->user_id" :options="$users->pluck('name', 'id')" span="2" />
        <x-field name="observacoes" label="Observações" type="textarea" :value="$m?->observacoes" span="3" />
        <x-field name="ativo" label="Ativo" type="checkbox" :value="$m?->ativo ?? true" />
</div>
