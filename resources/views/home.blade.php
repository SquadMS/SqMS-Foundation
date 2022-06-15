@extends('sqms-foundation::structure.layout', [
    'mainClass' => 'justify-center'
])

@section('content')
<section>
    <div class="container mx-auto px-4">
        <div class="flex flex-col items-center flex-wrap">
            <h1>{{ __('sqms-foundation::pages/home.heading') }}</h1>
            <img src="https://squadms.com/img/logo.svg" alt="SquadMS Logo" class="max-w-full h-auto">
        </div>
    </div>
</section>
@endsection
