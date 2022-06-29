<x-sqms-foundation::templates.page :title="__('sqms-foundation::pages/profile.heading', ['name' => $user->name])">
    <div class="md:sqmsf-flex sqmsf-no-wrap">
        <!-- Info Frame -->
        <div class="sqmsf-w-full md:sqmsf-w-3/12 md:sqmsf-mr-2 sqmsf-p-4 sqmsf-bg-gray-200">
            <img class="sqmsf-w-full sqmsf-mb-6 sqmsf-aspect-square" src="{{ $user->avatar }}" />

            <h2 class="sqmsf-font-bold sqmsf-text-xl sqmsf-whitespace-nowrap sqmsf-text-ellipsis sqmsf-overflow-hidden">{{ $user->name }}</h1>
            <p class="sqmsf-whitespace-nowrap sqmsf-text-ellipsis sqmsf-overflow-hidden">{{ $user->steam_id_64 }}</p>
        </div>

        <!-- Content Frame -->
        <livewire:sqms-foundation::profile-tabs :user="$user" />
    </div>

    @pushOnce('styles')
    @livewireStyles
    @endPushOnce

    @pushOnce('scripts')
    @livewireScripts
    @endPushOnce
</x-sqms-foundation::templates.page>