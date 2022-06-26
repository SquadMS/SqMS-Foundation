@props(['for'])

@error($for)
    <p {{ $attributes->merge(['class' => 'sqmsf-text-sm sqmsf-text-red-600']) }}>{{ $message }}</p>
@enderror