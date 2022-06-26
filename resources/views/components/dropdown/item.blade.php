@props(['active' => false, 'disabled' => false, 'link' => '#', 'title'])

<li>
    <a {{ $attributes->merge(['class' => 'sqmsf-block sqmsf-px-2 sqmsf-py-1 sqmsf-whitespace-nowrap' . ($active ? ' active' : '') . ($disabled ? ' disabled' : '')]) }} href="{{ $link }}">{{ $title }}</a>
</li>
