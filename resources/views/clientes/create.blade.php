```blade
<form action="{{ route('clientes.store') }}" method="POST">
    @csrf

    <div class="row">

        <div class="col-md-3 mb-3">
            <label class="form-label">Tipo</label>

            <select name="tipo" class="form-select">
                <option value="">Selecione</option>

                <option value="Pessoa Fisica"
                    {{ old('tipo', $cliente['tipo'] ?? '') == 'Pessoa Fisica' ? 'selected' : '' }}>
                    Pessoa Física
                </option>

                <option value="Pessoa Juridica"
                    {{ old('tipo', $cliente['tipo'] ?? '') == 'Pessoa Juridica' ? 'selected' : '' }}>
                    Pessoa Jurídica
                </option>
            </select>

            @error('tipo')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-5 mb-3">
            <label class="form-label">Nome</label>

            <input type="text"
                   name="nome"
                   class="form-control"
                   value="{{ old('nome', $cliente['nome'] ?? '') }}">

            @error('nome')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">Nome Fantasia</label>

            <input type="text"
                   name="nome_fantasia"
                   class="form-control"
                   value="{{ old('nome_fantasia', $cliente['nome_fantasia'] ?? '') }}">

            @error('nome_fantasia')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">CPF / CNPJ</label>

            <input type="text"
                   name="cpf_cnpj"
                   class="form-control"
                   value="{{ old('cpf_cnpj', $cliente['cpf_cnpj'] ?? '') }}">

            @error('cpf_cnpj')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">RG / IE</label>

            <input type="text"
                   name="rg_ie"
                   class="form-control"
                   value="{{ old('rg_ie', $cliente['rg_ie'] ?? '') }}">

            @error('rg_ie')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">E-mail</label>

            <input type="email"
                   name="email"
                   class="form-control"
                   value="{{ old('email', $cliente['email'] ?? '') }}">

            @error('email')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">Telefone</label>

            <input type="text"
                   name="telefone"
                   class="form-control"
                   value="{{ old('telefone', $cliente['telefone'] ?? '') }}">

            @error('telefone')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">WhatsApp</label>

            <input type="text"
                   name="whatsapp"
                   class="form-control"
                   value="{{ old('whatsapp', $cliente['whatsapp'] ?? '') }}">

            @error('whatsapp')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">CEP</label>

            <input type="text"
                   name="cep"
                   class="form-control"
                   value="{{ old('cep', $cliente['cep'] ?? '') }}">

            @error('cep')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-6 mb-3">
            <label class="form-label">Endereço</label>

            <input type="text"
                   name="endereco"
                   class="form-control"
                   value="{{ old('endereco', $cliente['endereco'] ?? '') }}">

            @error('endereco')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-2 mb-3">
            <label class="form-label">Número</label>

            <input type="text"
                   name="numero"
                   class="form-control"
                   value="{{ old('numero', $cliente['numero'] ?? '') }}">

            @error('numero')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">Complemento</label>

            <input type="text"
                   name="complemento"
                   class="form-control"
                   value="{{ old('complemento', $cliente['complemento'] ?? '') }}">

            @error('complemento')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">Bairro</label>

            <input type="text"
                   name="bairro"
                   class="form-control"
                   value="{{ old('bairro', $cliente['bairro'] ?? '') }}">

            @error('bairro')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">Cidade</label>

            <input type="text"
                   name="cidade"
                   class="form-control"
                   value="{{ old('cidade', $cliente['cidade'] ?? '') }}">

            @error('cidade')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-4 mb-3">
            <label class="form-label">Estado</label>

            <input type="text"
                   name="estado"
                   maxlength="2"
                   class="form-control"
                   value="{{ old('estado', $cliente['estado'] ?? '') }}">

            @error('estado')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-12 mb-3">
            <label class="form-label">Observações</label>

            <textarea name="observacoes"
                      class="form-control"
                      rows="4">{{ old('observacoes', $cliente['observacoes'] ?? '') }}</textarea>

            @error('observacoes')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>


        <div class="col-md-12 mb-3">

            <div class="form-check">

                <input type="hidden" name="ativo" value="0">

                <input type="checkbox"
                       name="ativo"
                       value="1"
                       class="form-check-input"
                       id="ativo"
                       {{ old('ativo', $cliente['ativo'] ?? true) ? 'checked' : '' }}>

                <label class="form-check-label" for="ativo">
                    Ativo
                </label>

            </div>

            @error('ativo')
                <div class="text-danger">{{ $message }}</div>
            @enderror

        </div>

    </div>

    <button type="submit" class="btn btn-primary">
        Salvar
    </button>

</form>
```
