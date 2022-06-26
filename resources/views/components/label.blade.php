@props(['value'])

<label {{ $attributes->merge(['class' => 'sqmsf-block sqmsf-font-medium sqmsf-text-sm sqmsf-text-gray-700']) }}>
    {{ $value ?? $slot }}
</label>