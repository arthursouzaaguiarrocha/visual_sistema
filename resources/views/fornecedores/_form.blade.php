<div class="row g-3">
    <x-campo name="nome" label="Nome / Razão social" col="6" required maxlength="255" :value="$fornecedor?->nome" />
    <x-campo name="cnpj_cpf" label="CNPJ / CPF" col="3" maxlength="20" :value="$fornecedor?->cnpj_cpf" />
    <x-campo name="contato_nome" label="Nome do contato" col="3" maxlength="255" :value="$fornecedor?->contato_nome" />

    <x-campo name="telefone" label="Telefone" col="4" maxlength="20" :value="$fornecedor?->telefone" />
    <x-campo name="email" label="E-mail" type="email" col="8" maxlength="255" :value="$fornecedor?->email" />

    <x-campo name="cep" label="CEP" col="3" maxlength="10" :value="$fornecedor?->cep" />
    <x-campo name="endereco" label="Endereço" col="9" maxlength="255" :value="$fornecedor?->endereco" />

    <x-campo name="cidade" label="Cidade" col="10" maxlength="100" :value="$fornecedor?->cidade" />
    <x-campo name="estado" label="UF" col="2" maxlength="2" :value="$fornecedor?->estado" />

    <x-area name="observacoes" label="Observações" :value="$fornecedor?->observacoes" />
    <x-ativo :value="$fornecedor?->ativo ?? true" />
</div>

<x-botoes :voltar="route('fornecedores.index')" />
