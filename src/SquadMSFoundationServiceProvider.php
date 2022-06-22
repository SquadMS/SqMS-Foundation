<?php

namespace SquadMS\Foundation;

use CodeZero\LocalizedRoutes\LocalizedUrlGenerator;
use CodeZero\LocalizedRoutes\UrlGenerator;
use Filament\Forms\Components\TextInput;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Spatie\LaravelPackageTools\Package;
use SquadMS\Foundation\Auth\SteamLogin;
use SquadMS\Foundation\Console\DevPostInstall;
use SquadMS\Foundation\Console\Install;
use SquadMS\Foundation\Console\PermissionsSync;
use SquadMS\Foundation\Console\PublishAssets;
use SquadMS\Foundation\Contracts\SquadMSModuleServiceProvider;
use SquadMS\Foundation\Facades\SquadMSModuleRegistry as FacadesSquadMSModuleRegistry;
use SquadMS\Foundation\Facades\SquadMSPermissions as FacadesSquadMSPermissions;
use SquadMS\Foundation\Menu\MenuManager;
use SquadMS\Foundation\Modularity\SquadMSModuleRegistry;
use Illuminate\Console\Scheduling\Schedule;
use SquadMS\Foundation\Facades\MenuManager as FacadesMenuManager;
use SquadMS\Foundation\Filament\Resources\MenuItemResource;
use SquadMS\Foundation\Filament\Resources\MenuResource;
use SquadMS\Foundation\Filament\Resources\RBACResource;
use SquadMS\Foundation\Jobs\FetchUsers;
use SquadMS\Foundation\Models\SquadMSUser;
use SquadMS\Foundation\SDKData\SDKDataReader;

class SquadMSFoundationServiceProvider extends SquadMSModuleServiceProvider
{
    public static string $name = 'sqms-foundation';

    protected array $resources = [
        RBACResource::class,
        MenuResource::class,
        MenuItemResource::class,
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

        $this->app->singleton(MenuManager::class, fn () => new MenuManager());

        $this->app->singleton(SDKDataReader::class, function () {
            return new SDKDataReader('mapdata', '2.7.json');
        });
    }

    public function bootedModule(): void
    {
        FacadesSquadMSModuleRegistry::register(SquadMSModule::class);

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

        $this->callAfterResolving(Schedule::class, function (Schedule $schedule) {
            FacadesSquadMSModuleRegistry::runSchedulers($schedule);
        });

        $this->app->booted(function() {
            Config::set('filament-navigation.supported-locales', Config::get('sqms.locales'));
        });
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
        FacadesMenuManager::addItemType('URL', [
            TextInput::make('url')
                ->required()
        ]);   

        FacadesMenuManager::addItemType('Home');    
        FacadesMenuManager::addItemType('Profile');
        FacadesMenuManager::addItemType('Account Settings');
    }

    public function schedule(Schedule $schedule): void
    {
        /* Fetch unfetched or outdated users */
        $schedule->job(new FetchUsers())->withoutOverlapping()->everyFiveMinutes();
    }
}
