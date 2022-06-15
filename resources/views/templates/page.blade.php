@extends('sqms-foundation::structure.layout')

@section('content')
<section class="mt-6">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap ">
            <div class="relative flex-grow max-w-full flex-1">
                <h1>@yield('title')</h1>
            </div>
        </div>

        @yield('page-content')
    </div>
</section>
@endsection