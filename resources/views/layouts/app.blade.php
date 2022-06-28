<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ $direction ? 'rtl' : 'ltr' }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>{{ config('app.name', 'SquadMS') }}</title>

        @websocketToken

        <!-- CSRF -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <!-- Styles -->
        @include('sqms-foundation::structure.styles')
        <link href="{{ mix('css/sqms.css', 'vendor/sqms-foundation') }}" rel="stylesheet">
        <link href="{{ mix('css/flag-icons.css', 'vendor/sqms-foundation') }}" rel="stylesheet">
        @stack('styles')
    </head>
    <body {{ $attributes->merge(['class' => 'sqmsf-min-h-screen sqmsf-m-0 sqmsf-flex sqmsf-flex-col sqmsf-bg-gray-100', 'dir' =>  $direction ? 'rtl' : 'ltr']) }}">
        <!-- Check WebP as early as possible -->
        <script src="{{ mix('js/webp.js', 'vendor/sqms-foundation') }}"></script>

        <x-sqms-foundation::navigation.navbar :brand="config('app.name', 'SquadMS')">            
            <x-slot name="menu">
                {!! $navWalker->render() !!}
            </x-slot>
            
            <x-slot name="extra">
                @if (count($locales))
                    <x-sqms-foundation::navigation.dropdown>
                        <x-slot name="title">
                            <span class="fi {{ $currentLocaleClass }}"></span>
                        </x-slot>

                        <x-slot name="links">
                            @foreach ($locales as $locale => $data)
                                <x-sqms-foundation::dropdown.item :link="$data['url']">
                                    <x-slot name="title">
                                        <span class="fi {{ $data['class'] }}"></span> {{ $data['name'] }}
                                    </x-slot>
                                </x-sqms-foundation::dropdown.item>
                            @endforeach
                        </x-slot>
                    </x-sqms-foundation::navigation.dropdown>
                @endif
            </x-slot>
        </x-sqms-foundation::navigation.navbar>

        <main class="sqmsf-flex-grow sqmsf-flex sqmsf-flex-col sqmsf-bg-white {{ $mainClass }}" {!! $mainAttributes ?? '' !!} role="main">
            {{ $slot }}
        </main>

        @include('sqms-foundation::structure.footer')

        <!-- Scripts -->
        <script src="//unpkg.com/alpinejs" defer></script>
        @stack('scripts')
        @include('sqms-foundation::structure.scripts')
    </body>
</html>
