@extends('sqms-foundation::structure.layout')

@section('content')
<section class="mt-6">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap ">
            <div class="relative flex-grow max-w-full flex-1">
                <h1>{{ __('sqms-foundation::pages/profile.heading', ['name' => $user->name . '('. $user->steam_id_64 . ')']) }}</h1>
            </div>
        </div>
    </div>
</section>
@endsection
