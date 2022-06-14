@props(['active' => false, 'title'])

<li 
    x-data=="{ open: false }"
    {{ $attributes->merge(['class' => 'nav-item dropdown' . ($active ? ' active' : '')]) }}
>
    <a 
        class="inline-block py-2 px-4 no-underline  inline-block w-0 h-0 ml-1 align border-b-0 border-t-1 border-r-1 border-l-1"
        href="#"
        role="button"
        data-bs-toggle="dropdown"
        aria-expanded="false">
        {{ $title }}
    </a>

    <ul class="list-none">
        {{ $links }}
    </ul>
</li>
