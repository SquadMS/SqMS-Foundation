<?php

namespace SquadMS\Foundation;

use CodeZero\LocalizedRoutes\UrlGenerator as BaseUrlGenerator;
use Illuminate\Support\Facades\Config;

class SquadMSUrlGenerator extends BaseUrlGenerator
{
    /**
     * @inheritDoc
     */
    protected function getSupportedLocales()
    {
        return Config::get('sqms.locales', []);
    }
}
