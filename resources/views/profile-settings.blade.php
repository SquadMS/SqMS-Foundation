@extends('sqms-foundation::structure.layout')

@section('content')
<section class="mt-6">
    <div class="container mx-auto px-4">
        <div class="flex flex-wrap  mb-5">
            <div class="relative flex-grow max-w-full flex-1">
                <h1>{{ __('sqms-foundation::pages/profile-settings.heading', ['name' => $user->name . '('. $user->steam_id_64 . ')']) }}</h1>
            </div>
        </div>

        @if (config('session.driver') === 'database')
        <div class="flex flex-wrap  mb-5">
            <div class="w-full">
                <h3>Active Sessions</h3>
            </div>
            <div class="w-full">
                @php
                    $sessions = $user->getRunningSessions();
                @endphp
                @if ($sessions->count())
                    @foreach ($user->getRunningSessions() as $session)
                        <div class="flex">
                            <div>
                                @if ($session->agent->isDesktop())
                                    <svg fill="none" width="32" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="text-gray-700">
                                        <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                    </svg>
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="text-gray-700">
                                        <path d="M0 0h24v24H0z" stroke="none"></path><rect x="7" y="4" width="10" height="16" rx="1"></rect><path d="M11 5h2M12 17v.01"></path>
                                    </svg>
                                @endif
                            </div>

                            <div class="ml-2">
                                <div>
                                    {{ $session->agent->platform() }} - {{ $session->agent->browser() }}
                                </div>

                                <div>
                                    <div class="text-xs font-weight-lighter text-gray-700">
                                        {{ $session->ip_address }},

                                        @if ($session->is_current_device)
                                            <span class="text-green-500 font-bold">{{ __('This device') }}</span>
                                        @else
                                            {{ __('Last active') }} {{ $session->last_active }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <p class="text-xl font-light">No active sessions.</p>
                @endif
            </div>
        </div>
        @endif

        @if ($user->id === Auth::user()->id)
        <div class="flex flex-wrap  mb-5">
            <div class="relative flex-grow max-w-full flex-1 px-4">
                <div class="relative flex flex-col min-w-0 rounded break-words border bg-white border-1 border-gray-300">
                    <div class="flex-auto p-6">
                        <h5 class="mb-3">Logout other devices</h5>
                        <form action="{{ route(Config::get('sqms.routes.def.logoutOtherDevices.name')) }}" method="POST">
                            @csrf
        
                            <button type="submit" class="inline-block align-middle text-center select-none border font-normal whitespace-no-wrap rounded py-1 px-3 leading-normal no-underline bg-red-600 text-white hover:bg-red-700">Log out other devices</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        @endif
    </div>
</section>
@endsection
