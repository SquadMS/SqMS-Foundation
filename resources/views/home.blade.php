@extends('sqms-foundation::structure.layout', [
    'mainClass' => 'justify-content-center'
])

@section('content')
<section>
    <div class="container mx-auto sm:px-4">
        <div class="flex flex-wrap ">
            <div class="relative flex-grow max-w-full flex-1 px-4 text-center">
                <h1>{{ __('sqms-default-theme::pages/home.heading') }}</h1>
                <img src="https://squadms.com/img/logo.svg" alt="SquadMS Logo" class="max-w-full h-auto">
            </div>
        </div>
    </div>
</section>
@endsection
