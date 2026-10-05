@php($m = $cliente ?? null)
<div class="grid grid-cols-1 gap-4 md:grid-cols-3">
        <x-field name="tipo" label="Tipo" type="select" :value="$m?->tipo ?? 'Pessoa Fisica'" :options="['Pessoa Fisica' => 'Pessoa Física', 'Pessoa Juridica' => 'Pessoa Jurídica']" required :blank="false" />
        <x-field name="nome" label="Nome / Razão social" :value="$m?->nome" required span="2" />
        <x-field name="nome_fantasia" label="Nome fantasia" :value="$m?->nome_fantasia" />
        <x-field name="cpf_cnpj" label="CPF / CNPJ" :value="$m?->cpf_cnpj" />
        <x-field name="rg_ie" label="RG / IE" :value="$m?->rg_ie" />
        <x-field name="email" label="E-mail" type="email" :value="$m?->email" />
        <x-field name="telefone" label="Telefone" type="tel" :value="$m?->telefone" required />
        <x-field name="whatsapp" label="WhatsApp" type="tel" :value="$m?->whatsapp" />
        <x-field name="cep" label="CEP" :value="$m?->cep" />
        <x-field name="endereco" label="Endereço" :value="$m?->endereco" span="2" />
        <x-field name="numero" label="Número" :value="$m?->numero" />
        <x-field name="complemento" label="Complemento" :value="$m?->complemento" />
        <x-field name="bairro" label="Bairro" :value="$m?->bairro" />
        <x-field name="cidade" label="Cidade" :value="$m?->cidade" />
        <x-field name="estado" label="UF" type="select" :value="$m?->estado" :options="['AC' => 'AC', 'AL' => 'AL', 'AP' => 'AP', 'AM' => 'AM', 'BA' => 'BA', 'CE' => 'CE', 'DF' => 'DF', 'ES' => 'ES', 'GO' => 'GO', 'MA' => 'MA', 'MT' => 'MT', 'MS' => 'MS', 'MG' => 'MG', 'PA' => 'PA', 'PB' => 'PB', 'PR' => 'PR', 'PE' => 'PE', 'PI' => 'PI', 'RJ' => 'RJ', 'RN' => 'RN', 'RS' => 'RS', 'RO' => 'RO', 'RR' => 'RR', 'SC' => 'SC', 'SP' => 'SP', 'SE' => 'SE', 'TO' => 'TO']" />
        <x-field name="observacoes" label="Observações" type="textarea" :value="$m?->observacoes" span="3" />
        <x-field name="ativo" label="Ativo" type="checkbox" :value="$m?->ativo ?? true" />
</div>
