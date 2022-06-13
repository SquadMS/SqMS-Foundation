@props(['active' => false, 'disabled' => false, 'link' => '#', 'onClick' => false, 'title'])

<li {{ isset($attributes) ? $attributes->except(['slot'])->merge(['class' => 'nav-item']) : '' }}>
    <a class="inline-block py-2 px-4 no-underline {{ $opacity-75 ? ' opacity-75' : '' }} {{ $active ? ' active' : '' }}" href="{{ is_callable($link) ? $link() : $link }}" {{ $onClick ? 'onClick="' . $onClick . '"' : ''}}>{!! $title !!}</a>
    {!! $slot ?? '' !!}
</li>