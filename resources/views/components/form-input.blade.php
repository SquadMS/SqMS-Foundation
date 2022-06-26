@props(['id', 'name', 'disabled' => false, 'type' => 'text', 'placeholder' => '', 'label' => false, 'help' => false])

@php
    $id = $id ?? ($attributes->whereStartsWith('wire:model')->first() ? md5($attributes->whereStartsWith('wire:model')->first()) : null) ?? \Illuminate\Support\Str::random();
@endphp

<div {{ $attributes->whereDoesntStartWith('wire:') }}>
    @if ($label)
        <label for="{{ $id }}" class="sqmsf-rm-label">{{ $label }}</label>
    @endif
    <input {{ $attributes->whereStartsWith('wire:') }} id="{{ $id }}" class="sqmsf-block sqmsf-appearance-none sqmsf-w-full sqmsf-py-1 sqmsf-px-2 sqmsf-mb-1 sqmsf-text-base sqmsf-leading-normal sqmsf-bg-white sqmsf-text-gray-800 sqmsf-border sqmsf-border-gray-200 sqmsf-rounded {{ $name && $errors->has($name) ? 'sqmsf-bg-red-700' : '' }}" name="{{ $name }}" type="{{ $type }}" placeholder="{{ $placeholder }}" aria-label="{{ $label ?? $placeholder }}" {{ $disabled ? 'disabled' : ''}}>

    @if ($help)
        <div id="{{ $id }}Help" class="sqmsf-block sqmsf-mt-1">{{ $help }}</div>
    @endif

    @if ($name)
        @error($name) 
            <div id="validation{{ $id }}" class="sqmsf-hidden sqmsf-mt-1 sqmsf-text-sm sqmsf-text-red">
                {{ $message }}
            </div>
        @enderror
    @endif
</div>