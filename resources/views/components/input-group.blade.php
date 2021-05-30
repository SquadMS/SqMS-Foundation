@props(['id', 'name', 'disabled' => false, 'type' => 'text', 'placeholder' => '', 'label' => false, 'help' => false])

@php
    $id = $id ?? \Illuminate\Support\Str::random();
@endphp

<div {{ $attributes->merge(['class' => 'input-group']) }}>
    @if ($label)
        <label for="{{ $id }}" class="form-label">{{ $label }}/label>
    @endif
    <input id="{{ $id }}" class="form-control {{ $name && $errors->has($name) ? 'is-invalid' : '' }}" name="{{ $name }}" type="{{ $type }}" placeholder="{{ $placeholder }}" aria-label="{{ $label ?? $placeholder }}" {{ $disabled ? 'disabled' : ''}}>

    @if ($help)
        <div id="{{ $id }}Help" class="form-text">{{ $help }}</div>
    @endif

    @if ($name)
        @error($name) 
            <div id="validation{{ $id }}" class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    @endif
</div>