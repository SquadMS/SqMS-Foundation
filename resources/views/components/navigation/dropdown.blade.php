@props(['active' => false, 'trigger' => false, 'title'])

<li 
    x-data="{ open: false }"
    {{ $attributes->merge(['class' => 'relative' . ($active ? ' active' : '')]) }}
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
        class="absolute ltr:right-0 list-none px-0 py-2 border border-slate-300 border-solid"
        style="display: none;"
        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="transform opacity-0 scale-95"
        x-transition:enter-end="transform opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-75"
        x-transition:leave-start="transform opacity-100 scale-100"
        x-transition:leave-end="transform opacity-0 scale-95"
        x-show="open"
        @click="open = false"
        @click.away="open = false"
    >
        {{ $links }}
    </ul>
</li>
