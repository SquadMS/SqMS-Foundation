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
