<x-page-template :title="__('sqms-foundation::pages/profile.heading', ['name' => $user->name . '('. $user->steam_id_64 . ')'])">
    <div class="md:sqmsf-flex sqmsf-no-wrap">
        <div class="sqmsf-w-full md:sqmsf-w-3/12 md:sqmsf-mr-2 sqmsf-px-4 sqmsf-pt-4 sqmsf-bg-gray-200">
            <img class="sqmsf-w-full sqmsf-mb-6" src="{{ $user->avatar }}" />

            <h1 class="sqmsf-font-bold sqmsf-text-xl sqmsf-whitespace-nowrap sqmsf-text-ellipsis sqmsf-overflow-hidden">{{ $user->name }}</h1>
        </div>
        <div class="sqmsf-w-full md:sqmsf-w-9/12 md:sqmsf-ml-2 sqmsf-px-4 sqmsf-pt-4 sqmsf-bg-gray-200">
            <h2>About</h2>
        </div>
    </div>
</x-page-template>