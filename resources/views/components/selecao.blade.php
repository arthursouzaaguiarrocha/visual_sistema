@props(['name', 'label', 'options' => [], 'value' => null, 'required' => false, 'col' => 6, 'placeholder' => 'Selecione...'])

<div class="col-md-{{ $col }}">
    <label for="{{ $name }}" class="form-label">
        {{ $label }} @if ($required)<span class="text-danger">*</span>@endif
    </label>
    <select name="{{ $name }}" id="{{ $name }}"
            {{ $attributes->class(['form-select', 'is-invalid' => $errors->has($name)]) }}
            @required($required)>
        <option value="">{{ $placeholder }}</option>
        @foreach ($options as $chave => $texto)
            <option value="{{ $chave }}" @selected((string) old($name, $value) === (string) $chave)>{{ $texto }}</option>
        @endforeach
    </select>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
