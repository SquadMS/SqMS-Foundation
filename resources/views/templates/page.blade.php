@extends('sqms-foundation::structure.layout')

@section('content')
<section class="bg-gray-200 py-5">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap">
            <div class="relative flex-grow max-w-full flex-1">
                <h1 class="text-xl font-bold">@yield('title')</h1>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container mx-auto px-4 py-5">
        @yield('page-content')
    </div>
</section>
@endsection