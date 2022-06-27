<x-page-template :title="__('sqms-foundation::pages/profile-settings.heading', ['name' => $user->name . '('. $user->steam_id_64 . ')'])">
@if (config('session.driver') === 'database')
<div class="sqmsf-flex sqmsf-flex-wrap sqmsf-mb-5">
    <div class="sqmsf-w-full">
        <h3>Active Sessions</h3>
    </div>
    <div class="sqmsf-w-full">
        @php
            $sessions = $user->getRunningSessions();
        @endphp
        @if ($sessions->count())
            @foreach ($user->getRunningSessions() as $session)
                <div class="sqmsf-flex">
                    <div>
                        @if ($session->agent->isDesktop())
                            <svg fill="none" width="32" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor" class="sqmsf-text-gray-700">
                                <path d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round" class="sqmsf-text-gray-700">
                                <path d="M0 0h24v24H0z" stroke="none"></path><rect x="7" y="4" width="10" height="16" rx="1"></rect><path d="M11 5h2M12 17v.01"></path>
                            </svg>
                        @endif
                    </div>

                    <div class="sqmsf-ml-2">
                        <div>
                            {{ $session->agent->platform() }} - {{ $session->agent->browser() }}
                        </div>

                        <div>
                            <div class="sqmsf-text-xs sqmsf-font-weight-lighter sqmsf-text-gray-700">
                                {{ $session->ip_address }},

                                @if ($session->is_current_device)
                                    <span class="sqmsf-text-green-500 sqmsf-font-bold">{{ __('This device') }}</span>
                                @else
                                    {{ __('Last active') }} {{ $session->last_active }}
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p class="sqmsf-text-xl sqmsf-font-light">No active sessions.</p>
        @endif
    </div>
</div>
@endif

@if ($user->id === Auth::user()->id)
<div class="sqmsf-flex sqmsf-flex-wrap sqmsf-mb-5">
    <div class="sqmsf-relative sqmsf-flex-grow sqmsf-max-w-full sqmsf-flex-1 sqmsf-px-4">
        <div class="sqmsf-relative sqmsf-flex sqmsf-flex-col sqmsf-min-w-0 sqmsf-rounded sqmsf-break-words sqmsf-border sqmsf-bg-white sqmsf-border-1 sqmsf-border-gray-300">
            <div class="sqmsf-flex-auto sqmsf-p-6">
                <h5 class="sqmsf-mb-3">Logout other devices</h5>
                <form action="{{ route(Config::get('sqms.routes.def.logoutOtherDevices.name')) }}" method="POST">
                    @csrf

                    <button type="submit" class="sqmsf-inline-block sqmsf-align-middle sqmsf-text-center sqmsf-select-none sqmsf-border sqmsf-font-normal sqmsf-whitespace-no-wrap sqmsf-rounded sqmsf-py-1 sqmsf-px-3 sqmsf-leading-normal sqmsf-no-underline sqmsf-bg-red-600 sqmsf-text-white hover:sqmsf-bg-red-700">Log out other devices</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endif
</x-page-template>
