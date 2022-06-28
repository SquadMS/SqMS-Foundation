<x-sqms-foundation::templates.page :title="__('sqms-foundation::pages/profile.heading', ['name' => $user->name])">
    <div class="md:sqmsf-flex sqmsf-no-wrap">
        <!-- Info Frame -->
        <div class="sqmsf-w-full md:sqmsf-w-3/12 md:sqmsf-mr-2 sqmsf-p-4 sqmsf-bg-gray-200">
            <img class="sqmsf-w-full sqmsf-mb-6" src="{{ $user->avatar }}" />

            <h2 class="sqmsf-font-bold sqmsf-text-xl sqmsf-whitespace-nowrap sqmsf-text-ellipsis sqmsf-overflow-hidden">{{ $user->name }}</h1>
            <p class="sqmsf-whitespace-nowrap sqmsf-text-ellipsis sqmsf-overflow-hidden">{{ $user->steam_id_64 }}</p>
        </div>

        <!-- Content Frame -->
        <div class="sqmsf-w-full md:sqmsf-w-9/12 md:sqmsf-ml-2 sqmsf-p4 sqmsf-flex sqmsf-flex-col sqmsf-bg-gray-200">
            <!-- Tabs -->
            <div class="sqmsf-flex sqmsf-flex-row">
                @foreach (['About', 'Achievements', 'Statistics'] as $title)
                <h3 class="sqmsf-px-4 sqmsf-py-2 sqmsf-border-black	sqmsf-border-solid sqmsf-border-y-2 sqmsf-border-r-2 first:sqmsf-border-l-2">{{ $title }}</h2>
                @endforeach
            </div>

            <!-- Content -->
            <div class="sqmsf-flex-grow sqmsf-border-black sqmsf-border-solid sqmsf-border-2">
                <h4>Country</h4>
                <p>Coming Soon</p>

                <h4>Bio</h4>
                <p>Coming Soon</p>
            </div>
        </div>
    </div>
</x-sqms-foundation::templates.page>