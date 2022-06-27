<x-app-layout>
    <section class="sqmsf-bg-gray-200 sqmsf-py-5">
        <div class="sqmsf-container sqmsf-mx-auto sqmsf-px-4">
            <div class="sqmsf-flex sqmsf-flex-wrap">
                <div class="sqmsf-relative sqmsf-flex-grow sqmsf-max-w-full sqmsf-flex-1">
                    <h1 class="sqmsf-text-xl sqmsf-font-bold sqmsf-whitespace-nowrap sqmsf-text-ellipsis sqmsf-overflow-hidden">{{ $title }}</h1>
                </div>
            </div>
        </div>
    </section>
    <section>
        <div class="sqmsf-container sqmsf-mx-auto sqmsf-px-4 sqmsf-py-5">
            {{ $slot }}
        </div>
    </section>
</x-app-layout>