<?php

namespace SquadMS\Foundation;

use CodeZero\LocalizedRoutes\LocalizedUrlGenerator;
use CodeZero\LocalizedRoutes\UrlGenerator;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Illuminate\Console\Scheduling\Schedule;
use Spatie\LaravelPackageTools\Package;
use SquadMS\Foundation\Auth\SteamLogin;
use SquadMS\Foundation\Console\DevPostInstall;
use SquadMS\Foundation\Console\Install;
use SquadMS\Foundation\Console\PermissionsSync;
use SquadMS\Foundation\Console\PublishAssets;
use SquadMS\Foundation\Contracts\SquadMSModuleServiceProvider;
use SquadMS\Foundation\Facades\SquadMSModuleRegistry as FacadesSquadMSModuleRegistry;
use SquadMS\Foundation\Facades\SquadMSPermissions as FacadesSquadMSPermissions;
use SquadMS\Foundation\Modularity\SquadMSModuleRegistry;
use SquadMS\Foundation\Filament\Resources\RBACResource;
use SquadMS\Foundation\Jobs\FetchUsers;
use SquadMS\Foundation\Models\SquadMSUser;
use SquadMS\Foundation\SDKData\SDKDataReader;
use RyanChandler\FilamentNavigation\Filament\Resources\NavigationResource;
use Spatie\LaravelSettings\SettingsContainer;
use SquadMS\Foundation\Facades\SquadMSNavigation;
use SquadMS\Foundation\Facades\SquadMSSettings;
use SquadMS\Foundation\Filament\Pages\ManageNavigationSlots;
use SquadMS\Foundation\Menu\MenuManager;
use SquadMS\Foundation\Settings\SettingsManager;
use SquadMS\Foundation\Themes\Settings\ThemesNavigationsSettings;
use SquadMS\Foundation\Themes\ThemeManager;

class SquadMSFoundationServiceProvider extends SquadMSModuleServiceProvider
{
    public static string $name = 'sqms-foundation';

    protected array $resources = [
        RBACResource::class,
    ];

    protected array $pages = [
        ManageNavigationSlots::class,
    ];

    public function configureModule(Package $package): void
    {
        $package->hasAssets()
                ->hasConfigFile('sqms')
                ->hasRoutes(['web']);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function registeringModule(): void
    {
        $this->app->singleton(SquadMSModuleRegistry::class, function () {
            return new SquadMSModuleRegistry();
        });

        $this->app->singleton(SquadMSPermissions::class, function () {
            return new SquadMSPermissions();
        });

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

        $this->app->singleton(SDKDataReader::class, function () {
            return new SDKDataReader('mapdata', '2.7.json');
        });

        $this->app->singleton(ThemeManager::class, function () {
            return new ThemeManager();
        });

        $this->app->singleton(SettingsManager::class, function () {
            return new SettingsManager();
        });

        $this->app->singleton(MenuManager::class, function () {
            return new MenuManager();
        });
    }

    public function bootedModule(): void
    {
        /* Settings */
        $this->app->booted(function() {
            /* Get the SettingsContainer and clear all registered settings */
            $settingsContainer = resolve(SettingsContainer::class);
            $settingsContainer->clearCache();

            /* Append all SQMS module settings to the configured ones */
            Config::set('settings.settings', array_merge(Config::get('settings.settings', []), SquadMSSettings::getSettings()));

            /* Load the new settings configuration */
            $settingsContainer->registerBindings();
        });

        /* Permissions */
        foreach (Config::get('sqms.permissions.definitions', []) as $definition => $displayName) {
            FacadesSquadMSPermissions::define(Config::get('sqms.permissions.module'), $definition, $displayName);
        }

        // Implicitly grant system admins all permissions
        Gate::before(function (SquadMSUser $user, $ability) {
            return $user->isSystemAdmin() ? true : null;
        });

        /* Add isAdmin directive */
        Blade::if('admin', function ($user) {
            return $user && ($user->isSystemAdmin() || $user->can('admin'));
        });

        Blade::directive('websocketToken', function ($expression) {
            return '<?php 
                if (($user = '.SquadMSUser::class.'::current())) {
                    if (($t = $user->getCurrentWebSocketToken())) {
                        $wat = $t->token;
                        echo \'<meta name="wat" content="\' . $wat . \'">\';
                    }
                }
            ?>';
        });

        Blade::componentNamespace('SquadMS\\Foundation\\View\\Components' , 'sqms-foundation');

        /* Make sure all module schedulers are registered once the Schedule has been resolved */
        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            FacadesSquadMSModuleRegistry::runSchedulers($schedule);
        });

        /* Re-Configure any 3rd party packages */
        $this->app->booted(function() {
            /* Make sure filament-navigation does use squadms locales */
            Config::set('filament-navigation.supported-locales', Config::get('sqms.locales'));
        });

        /* Group Navigations resource into System Management */
        NavigationResource::navigationGroup('System Management');
    }

    /**
     * The policy mappings for the application.
     *
     * @return array
     */
    public function policies()
    {
        return [
            Role::class        => RBACPolicy::class,
            SquadMSUser::class => UserPolicy::class,
        ];
    }

    protected function getCommands(): array
    {
        return [
            PublishAssets::class,
            PermissionsSync::class,
            DevPostInstall::class,
            Install::class,
        ];
    }

    public function addNavigationTypes(): void
    {
        SquadMSNavigation::addType('Home', fn () => route('home'));    
        SquadMSNavigation::addType('Profile', fn () => route('profile', [
            'steam_id_64' => SquadMSUser::current()->steam_id_64
        ]), condition: fn () => SquadMSUser::current());
        SquadMSNavigation::addType('Account Settings', fn () => route('profile-settings', [
            'steam_id_64' => SquadMSUser::current()->steam_id_64
        ]), condition: fn () => SquadMSUser::current());
    }

    public function schedule(Schedule $schedule): void
    {
        /* Fetch unfetched or outdated users */
        $schedule->job(new FetchUsers())->withoutOverlapping()->everyFiveMinutes();
    }

    public function settings(): array
    {
        return [
            ThemesNavigationsSettings::class
        ];
    }
}
