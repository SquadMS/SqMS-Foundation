@extends('sqms-foundation::structure.layout')

@section('content')
<section class="sqmsf-bg-gray-200 sqmsf-py-5">
    <div class="sqmsf-container sqmsf-mx-auto sqmsf-px-4">
        <div class="sqmsf-flex sqmsf-flex-wrap">
            <div class="sqmsf-relative sqmsf-flex-grow sqmsf-max-w-full sqmsf-flex-1">
                <h1 class="text-xl font-bold">@yield('title')</h1>
            </div>
        </div>
    </div>
</section>
<section>
    <div class="sqmsf-container sqmsf-mx-auto sqmsf-px-4 sqmsf-py-5">
        @yield('page-content')
    </div>
</section>
@endsection