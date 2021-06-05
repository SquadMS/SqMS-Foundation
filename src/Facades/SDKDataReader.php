<?php

namespace SquadMS\Foundation\Facades;

use Illuminate\Support\Facades\Facade;
use SquadMS\Foundation\SDKData\SDKDataReader as FoundationSDKDataReader;

class SDKDataReader extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return FoundationSDKDataReader::class;
    }
}