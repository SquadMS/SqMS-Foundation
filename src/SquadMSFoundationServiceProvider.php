<?php

namespace SquadMS\Foundation;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Config;;
use SquadMS\Foundation\Auth\SteamLogin;

class SquadMSFoundationServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(SteamLogin::class, function () {
            return new SteamLogin();
        });

        $loader = AliasLoader::getInstance();
        $loader->alias('NavigationHelper', \SquadMS\Foundation\Helpers\NavigationHelper::class);
        $loader->alias('LocaleHelper', \SquadMS\Foundation\Helpers\LocaleHelper::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        /* Configuration */
        $this->mergeConfigFrom(__DIR__.'/../config/sqms.php', 'sqms');
        $this->app->booted(function () {
            foreach (Config::get('sqms.config-overrides') as $key => $value) {
                Config::set([$key => $value]);
            }
        });

        /* Migrations */
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        /* Load Translations */
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'sqms-foundation');

        /* Publish Assets */
        if ($this->app->runningInConsole()) {
            // Publish assets
            $this->publishes([
                __DIR__.'/../public' => public_path('themes/sqms-foundation'),
            ], 'assets');
        }
    }
}
