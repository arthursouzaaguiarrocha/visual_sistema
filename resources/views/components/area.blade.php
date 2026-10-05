@props(['name', 'label', 'value' => null, 'rows' => 3, 'col' => 12])

<div class="col-md-{{ $col }}">
    <label for="{{ $name }}" class="form-label">{{ $label }}</label>
    <textarea name="{{ $name }}" id="{{ $name }}" rows="{{ $rows }}"
              {{ $attributes->class(['form-control', 'is-invalid' => $errors->has($name)]) }}>{{ old($name, $value) }}</textarea>
    @error($name)
        <div class="invalid-feedback">{{ $message }}</div>
    @enderror
</div>
