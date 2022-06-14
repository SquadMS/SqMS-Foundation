@props(['active' => false, 'trigger' => false, 'title'])

<li 
    x-data="{ open: false }"
    {{ $attributes->merge(['class' => 'nav-item dropdown' . ($active ? ' active' : '')]) }}
>
    <span 
        class="inline-block py-2 px-4 no-underline"
        role="button"
        @click="open = ! open"
    >
        {{ $title }}
        {{ $trigger }}
    </span>

    <ul
        class="list-none"
        style="display: none;"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        x-show="open"
        @click="open = false">
    >
        {{ $links }}
    </ul>
</li>
