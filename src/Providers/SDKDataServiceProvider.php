<?php

namespace SquadMS\Foundation\Providers;

use Illuminate\Support\ServiceProvider;
use SquadMS\Foundation\SDKData\SDKDataReader;

class SDKDataServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SDKDataReader::class, function () {
            return new SDKDataReader('mapdata', '2.7.json');
        });
    }

    public function boot()
    {
        //
    }
}