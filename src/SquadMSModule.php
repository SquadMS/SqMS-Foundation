<?php

namespace SquadMS\Foundation;

use Illuminate\Support\Facades\Artisan;
use SquadMS\Foundation\Modularity\Contracts\SquadMSModule as SquadMSModuleContract;

class SquadMSModule extends SquadMSModuleContract {
    static function getIdentifier() : string
    {
        return 'sqms-foundation';
    }

    static function getName() : string
    {
        return 'SquadMS Foundation';
    }

    static function publishAssets() : void
    {
        Artisan::call('vendor:publish', [
            '--provider' => SquadMSFoundationServiceProvider::class,
            '--tag'     => 'assets',
        ]);
    }
}