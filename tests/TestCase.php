<?php

namespace SquadMS\Foundation\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;

class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();
        // additional setup
    }

    protected function getPackageProviders($app)
    {
        return [
            // Package Providers
            \Livewire\LivewireServiceProvider::class,
            \CodeZero\LocalizedRoutes\LocalizedRoutesServiceProvider::class,

            // SquadMS Foundation Providers
            \SquadMS\Foundation\SquadMSFoundationServiceProvider::class,
            \SquadMS\Foundation\Providers\ScheduleServiceProvider::class,
            \SquadMS\Foundation\Providers\PermissionsServiceProvider::class,
            \SquadMS\Foundation\Providers\RouteServiceProvider::class,
            \SquadMS\Foundation\Providers\AuthServiceProvider::class,
            \SquadMS\Foundation\Providers\LivewireServiceProvider::class,
            \SquadMS\Foundation\Providers\ViewServiceProvider::class,
            \SquadMS\Foundation\Providers\ModulesServiceProvider::class,
            \SquadMS\Foundation\Providers\CommandsServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        config()->set('localized-routes.supported-locales', [
            'en',
            'de',
        ]);
    }
}
