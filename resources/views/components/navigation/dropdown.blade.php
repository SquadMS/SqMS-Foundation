@props(['active' => false, 'trigger' => false, 'title'])

<li 
    x-data="{ open: false }"
    {{ $attributes->merge(['class' => 'sqmsf-relative' . ($active ? ' active' : '')]) }}
>
    <span 
        class="sqmsf-inline-block sqmsf-py-2 sqmsf-px-4 sqmsf-no-underline"
        role="button"
        @click="open = ! open"
    >
        {{ $title }}
        <span
            class="inline-block"
            :class="{ 'ltr:sqmsf-rotate-180 rtl:sqmsf--rotate-180 sqmsf-transform-gpu sqmsf-transition-transform': open }"
        >▼</span>
    </span>

    <ul
        class="md:sqmsf-absolute md:sqmsf-top-full md:sqmsf-z-20 md:ltr:sqmsf-right-0 md:rtl:sqmsf-left-0 sqmsf-list-none sqmsf-px-0 sqmsf-py-2 sqmsf-border sqmsf-border-slate-300 sqmsf-border-solid sqmsf-bg-white"
        style="display: none;"
        x-transition:enter="sqmsf-transition sqmsf-ease-out sqmsf-duration-200"
        x-transition:enter-start="sqmsf-transform sqmsf-opacity-0 sqmsf-scale-95"
        x-transition:enter-end="sqmsf-transform sqmsf-opacity-100 sqmsf-scale-100"
        x-transition:leave="sqmsf-transition sqmsf-ease-in sqmsf-duration-75"
        x-transition:leave-start="sqmsf-transform sqmsf-opacity-100 sqmsf-scale-100"
        x-transition:leave-end="sqmsf-transform sqmsf-opacity-0 sqmsf-scale-95"
        x-show="open"
        @click="open = false"
        @click.away="open = false"
    >
        {!! $links ?? '' !!}
    </ul>
</li>
