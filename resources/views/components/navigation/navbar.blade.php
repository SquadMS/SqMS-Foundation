@props(['menu' => false, 'extra' => false, 'brand'])

<nav
    x-data="{ open: false }"
    {{ $attributes->merge(['class' => 'bg-white']) }}
>
    <div class="relative container mx-auto flex flex-wrap items-center">
        <!-- Application brand-->
        <a href="{{ route(Config::get('sqms.routes.def.home.name')) }}">
            <x-sqms-foundation::brand class="block h-12 w-auto" />
        </a>

        <!-- Responsive toggle -->
        <button
            class="inline-block ltr:ml-auto rtl:mr-auto md:hidden p-3 border-2 border-slate-300 border-solid rounded-lg"
            x-transition:enter="transition ease-out duration-200"
            x-transition:enter-start="transform opacity-0 scale-95"
            x-transition:enter-end="transform opacity-100 scale-100"
            x-transition:leave="transition ease-in duration-75"
            x-transition:leave-start="transform opacity-100 scale-100"
            x-transition:leave-end="transform opacity-0 scale-95"
            @click="open = ! open"
        >
            <i 
                class="inline-block"
                :class="{ 'ltr:rotate-180 rtl:-rotate-180 transform-gpu transition-transform': open }"
            >
                ▼
            </i>
        </button>

        <!-- Responsive menu -->
        <ul
            class="absolute md:relative top-full z-10 basis-full md:basis-auto grow md:grow-0 block md:flex md:items-center list-none ltr:ml-auto rtl:mr-auto"
            :class="{ 'hidden': ! open }"
            x-show.transition="true"
        >
            @if ($menu)
                {{ $menu }}
            @endif

            @if ($extra)
                {{ $extra }}
            @endif
        </ul>
    </div>
</nav>
