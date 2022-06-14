@props(['active' => false, 'disabled' => false, 'link' => '#', 'title'])

<li>
    <a {{ $attributes->merge(['class' => 'whitespace-nowrap' . ($active ? ' active' : '') . ($disabled ? ' disabled' : '')]) }} href="{{ $link }}">{{ $title }}</a>
</li>