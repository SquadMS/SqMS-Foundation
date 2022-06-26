@if ($errors->any())
    <div {{ $attributes }}>
        <div class="sqmsf-font-medium sqmsf-text-red-600">{{ __('Whoops! Something went wrong.') }}</div>

        <ul class="sqmsf-mt-3 sqmsf-list-disc sqmsf-list-inside sqmsf-text-sm sqmsf-text-red-600">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif