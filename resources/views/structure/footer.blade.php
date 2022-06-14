<footer class="p-6">
    <div class="container mx-auto sm:px-4">
        <div class="flex flex-wrap ">
            <div class="w-full text-center md:w-1/2 pr-4 pl-4 md:text-left">
                {{ __('sqms-foundation::footer.copyright', ['name' => config('app.name'), 'year' => now()->year]) }}
            </div>
            <div class="w-full text-center md:w-1/2 pr-4 pl-4 md:text-right">
                {!! __('sqms-foundation::footer.powered-by') !!}
            </div>
        </div>
    </div>
</footer>
