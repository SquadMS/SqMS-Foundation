@props(['menu' => false, 'extra' => false])

<nav {{ $attributes->merge(['class' => 'bg-white']) }}>
    <div class="container mx-auto flex items-center">
        <!-- Application brand-->
        <a href="{{ route(Config::get('sqms.routes.def.home.name')) }}">
            <x-sqms-foundation::brand class="block h-12 w-auto" />
        </a>

        <!-- Responsive menu -->
        <ul class="flex items-center list-none ml-auto">
            @if ($menu)
                {{ $menu }}
            @endif

            @if ($extra)
                {{ $extra }}
            @endif
        </ul>
    </div>
</nav>
