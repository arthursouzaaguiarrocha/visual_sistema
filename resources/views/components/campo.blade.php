@props(['name', 'label', 'type' => 'text', 'value' => null, 'required' => false, 'col' => 6])

<div class="col-md-{{ $col }}">
    <label for="{{ $name }}" class="form-label">
        {{ $label }} @if ($required)<span class="text-danger">*</span>@endif
    </label>
    <input type="{{ $type }}" name="{{ $name }}" id="{{ $name }}"
           value="{{ old($name, $value) }}"
           {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}
           @required($required)>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
