@props(['menu' => false, 'extra' => false, 'brand'])

<nav
    x-data="{ open: false }"
    {{ $attributes->merge(['class' => 'sqmsf-bg-white sqmsf-relative']) }}
>
    <div class="sqmsf-container sqmsf-mx-auto sqmsf-px-4 sqmsf-flex sqmsf-flex-wrap sqmsf-items-center">
        <!-- Application brand-->
        <a href="{{ route(Config::get('sqms.routes.def.home.name')) }}">
            <x-sqms-foundation::brand class="sqmsf-block sqmsf-py-2 sqmsf-pr-2 sqmsf-h-12 sqmsf-w-auto" />
        </a>

        <!-- Responsive toggle -->
        <button
            class="sqmsf-inline-block ltr:sqmsf-ml-auto rtl:sqmsf-mr-auto md:sqmsf-hidden sqmsf-p-3 sqmsf-border-2 sqmsf-border-slate-300 sqmsf-border-solid sqmsf-rounded-lg"
            x-transition:enter="tsqmsf-ransition sqmsf-ease-out sqmsf-duration-200"
            x-transition:enter-start="sqmsf-transform sqmsf-opacity-0 sqmsf-scale-95"
            x-transition:enter-end="sqmsf-transform sqmsf-opacity-100 sqmsf-scale-100"
            x-transition:leave="sqmsf-transition sqmsf-ease-in sqmsf-duration-75"
            x-transition:leave-start="sqmsf-transform sqmsf-opacity-100 sqmsf-scale-100"
            x-transition:leave-end="sqmsf-transform sqmsf-opacity-0 sqmsf-scale-95"
            @click="open = ! open"
        >
            <i 
                class="sqmsf-inline-block"
                :class="{ 'ltr:sqmsf-rotate-180 rtl:sqmsf--rotate-180 sqmsf-transform-gpu sqmsf-transition-transform': open }"
            >
                ▼
            </i>
        </button>

        <!-- Responsive menu -->
        <div
            class="
                sqmsf-absolute sqmsf-z-10 sqmsf-top-full sqmsf-left-0 sqmsf-right-0 sqmsf-bg-white 
                md:sqmsf-relative md:sqmsf-bg-none md:sqmsf-flex md:ltr:sqmsf-ml-auto md:rtl:sqmsf-mr-auto
            "
            :class="{ 'sqmsf-hidden': ! open }"
            x-show.transition="true"
        >
            <ul
                class="
                    sqmsf-container sqmsf-mx-auto sqmsf-px-4 sqmsf-list-none sqmsf-flex sqmsf-flex-col
                    md:sqmsf-max-w-none md:sqmsf-flex-row md:sqmsf-px-0
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
