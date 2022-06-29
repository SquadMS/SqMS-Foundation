<div class="sqmsf-w-full md:sqmsf-w-9/12 md:sqmsf-ml-2 sqmsf-p4 sqmsf-flex sqmsf-flex-col sqmsf-bg-gray-200">
    <!-- Tabs -->
    <div class="sqmsf-flex sqmsf-flex-row">
        @foreach (array_keys($tabs) as $t)
        <h3 
            class="sqmsf-px-4 sqmsf-py-2 sqmsf-border-black	sqmsf-border-solid sqmsf-border-y-2 sqmsf-border-r-2 first:sqmsf-border-l-2"
            role="button"
            wire:click="openTab('{{ $t }}')"
        >{{ $t }}</h2>
        @endforeach
    </div>

    <!-- Content -->
    <div class="sqmsf-flex-grow sqmsf-border-black sqmsf-border-solid sqmsf-border-2">
        {{ $tabs[$tab] }}
    </div>
</div>