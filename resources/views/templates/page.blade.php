@extends('sqms-foundation::structure.layout')

@section('content')
<section class="bg-slate-600 py-4">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap ">
            <div class="relative flex-grow max-w-full flex-1">
                <h1>@yield('title')</h1>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="container mx-auto px-4">
        @yield('page-content')
    </div>
</section>
@endsection