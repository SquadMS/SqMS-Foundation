@props(['menu' => false, 'extra' => false, 'brand'])

<nav
    x-data="{ open: false }"
    {{ $attributes->merge(['class' => 'bg-white relative']) }}
>
    <div class="container mx-auto px-4 flex flex-wrap items-center">
        <!-- Application brand-->
        <a href="{{ route(Config::get('sqms.routes.def.home.name')) }}">
            <x-sqms-foundation::brand class="block p-2 h-12 w-auto" />
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
        <div
            class="
                absolute z-10 top-full left-0 right-0 bg-white 
                md:relative md:bg-none md:flex md:ltr:ml-auto md:rtl:mr-auto
            "
            :class="{ 'hidden': ! open }"
            x-show.transition="true"
        >
            <ul
                class="
                    container mx-auto px-4 list-none flex flex-col
                    md:max-w-none md:flex-row md:px-0
                "
            >
                @if ($menu)
                    {{ $menu }}
                @endif

                @if ($extra)
                    {{ $extra }}
                @endif
            </ul>
        </div>
    </div>
</nav>
