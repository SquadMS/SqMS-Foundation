<?php

namespace SquadMS\Foundation;

use CodeZero\LocalizedRoutes\LocalizedUrlGenerator;
use CodeZero\LocalizedRoutes\UrlGenerator;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Config;
use Spatie\LaravelPackageTools\Package;
use SquadMS\Foundation\Auth\SteamLogin;
use SquadMS\Foundation\Contracts\SquadMSModuleServiceProvider;

class SquadMSFoundationServiceProvider extends SquadMSModuleServiceProvider
{
    public function configureModule(Package $package): void
    {
        $package->name('sqms-foundation')
                ->hasConfigFile('sqms')
                ->hasTranslations()
                ->hasAssets();
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function registeringModule(): void
    {
        $this->app->singleton(SteamLogin::class, function () {
            return new SteamLogin();
        });

        $loader = AliasLoader::getInstance();
        $loader->alias('NavigationHelper', \SquadMS\Foundation\Helpers\NavigationHelper::class);
        $loader->alias('LocaleHelper', \SquadMS\Foundation\Helpers\LocaleHelper::class);
        
        $this->app->bind(LocalizedUrlGenerator::class, fn () => new class extends LocalizedUrlGenerator {
            protected function getOmitLocale()
            {
                return Config::get('sqms.omit_url_prefix_for_locale', null);
            }

            protected function getSupportedLocales()
            {
                return Config::get('sqms.locales', []);
            }
        });

        $this->app->bind(UrlGenerator::class, fn ($app, $parameters) => new SquadMSUrlGenerator(...$parameters));
    }
}
