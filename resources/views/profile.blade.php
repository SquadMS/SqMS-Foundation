@extends('sqms-foundation::templates.page')

@section('title')
    {{ __('sqms-foundation::pages/profile.heading', ['name' => $user->name . '('. $user->steam_id_64 . ')']) }}
@endsection

@section('page-content')
    <div>
        <div class="w-full md:w-3/12">
            <img src="{{ $user->avatar }}" />

            <h1>{{ $user->name }}</h1>
        </div>
        <div class="w-full md:w-9/12">
            <h2>About</h2>
        </div>
    </div>
@endsection