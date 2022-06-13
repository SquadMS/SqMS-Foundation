@extends('sqms-foundation::structure.layout')

@section('content')
<section class="mt-6">
    <div class="container">
        <div class="row">
            <div class="col">
                <h1>{{ __('sqms-foundation::pages/profile.heading', ['name' => $user->name . '('. $user->steam_id_64 . ')']) }}</h1>
            </div>
        </div>
    </div>
</section>
@endsection
