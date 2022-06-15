<footer class="p-6">
    <div class="container mx-auto sm:px-4">
        <div class="flex flex-wrap ">
            <div class="w-full text-center md:w-1/2 pr-4 pl-4 md:text-left">
                {{ __('sqms-foundation::footer.copyright', ['name' => config('app.name'), 'year' => now()->year]) }}
            </div>
            <div class="w-full text-center md:w-1/2 pr-4 pl-4 md:text-right">
                {!! __('sqms-foundation::footer.powered-by', ['brand' => '<a href="https://squadms.com" target="_blank"><img src="https://squadms.com/img/logo.svg" alt="SquadMS Logo" class="w-auto inline-block" style="height:1em"></a>']) !!}
            </div>
        </div>
    </div>
</footer>
