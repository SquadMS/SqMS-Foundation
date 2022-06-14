@props(['active' => false, 'disabled' => false, 'link' => '#', 'title'])

<li>
    <a {{ $attributes->merge(['class' => 'block px-2 py-1 whitespace-nowrap' . ($active ? ' active' : '') . ($disabled ? ' disabled' : '')]) }} href="{{ $link }}">{{ $title }}</a>
</li>
