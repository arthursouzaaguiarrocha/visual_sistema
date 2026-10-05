@props([
    'name',
    'label' => null,
    'type' => 'text',
    'value' => null,
    'options' => [],
    'required' => false,
    'step' => null,
    'span' => 1,
    'blank' => 'Selecione...',
])

@php
    $key = str_replace(['[', ']'], ['.', ''], $name);
    $id = str_replace('.', '_', $key);
    $current = old($key, $value);
    if ($current instanceof \DateTimeInterface) {
        $current = $type === 'datetime-local' ? $current->format('Y-m-d\TH:i') : $current->format('Y-m-d');
    }
    $base = 'mt-1.5 block w-full rounded-lg border-slate-200 bg-white text-sm text-slate-800 shadow-sm transition placeholder:text-slate-400 focus:border-indigo-400 focus:ring-2 focus:ring-indigo-500/20';
    $colClass = match ((int) $span) {
        2 => 'md:col-span-2',
        3 => 'md:col-span-3',
        default => '',
    };
@endphp

<div class="{{ $colClass }}">
    @if ($type === 'checkbox')
        <label class="mt-6 inline-flex items-center gap-2.5">
            <input type="hidden" name="{{ $name }}" value="0">
            <input type="checkbox" id="{{ $id }}" name="{{ $name }}" value="1" @checked((bool) $current)
                {{ $attributes->except('id')->merge(['class' => 'rounded border-slate-300 text-indigo-600 shadow-sm focus:ring-indigo-500/30']) }}>
            <span class="text-sm text-slate-700">{{ $label }}</span>
        </label>
    @else
        @if ($label)
            <label for="{{ $id }}" class="block text-sm font-medium text-slate-700">{{ $label }}@if ($required) <span class="text-red-500">*</span>@endif</label>
        @endif

        @if ($type === 'select')
            <select id="{{ $id }}" name="{{ $name }}" @required($required)
                {{ $attributes->except('id')->merge(['class' => $base]) }}>
                @if ($blank !== false)
                    <option value="">{{ $blank }}</option>
                @endif
                @foreach ($options as $optValue => $optLabel)
                    <option value="{{ $optValue }}" @selected((string) $current === (string) $optValue)>{{ $optLabel }}</option>
                @endforeach
            </select>
        @elseif ($type === 'textarea')
            <textarea id="{{ $id }}" name="{{ $name }}" rows="3" @required($required)
                {{ $attributes->except('id')->merge(['class' => $base]) }}>{{ $current }}</textarea>
        @else
            <input type="{{ $type }}" id="{{ $id }}" name="{{ $name }}" value="{{ $current }}" @required($required)
                @if ($step) step="{{ $step }}" @endif
                {{ $attributes->except('id')->merge(['class' => $base]) }}>
        @endif
    @endif

    @error($key)
        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
    @enderror
</div>
