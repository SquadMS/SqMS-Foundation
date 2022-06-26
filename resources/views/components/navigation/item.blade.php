@props(['active' => false, 'disabled' => false, 'link' => '#', 'onClick' => false, 'title'])

@php
    $colorClass = $active ? 'sqmsf-text-amber-400' : 'sqmsf-text-gray-700';
@endphp

<li {{ isset($attributes) ? $attributes->except(['slot'])->merge(['class' => $colorClass]) : '' }}>
    <a class="sqmsf-inline-block sqmsf-py-2 sqmsf-px-4 sqmsf-no-underline sqmsf-text-inherit" href="{{ is_callable($link) ? $link() : $link }}" {{ $onClick ? 'onClick="' . $onClick . '"' : ''}}>
        {!! $title !!}
    </a>
</li>
