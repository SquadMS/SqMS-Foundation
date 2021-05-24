<?php

namespace SquadMS\Foundation\Modularity\Contracts;

abstract class SquadMSModule
{
    abstract static function getIdentifier() : string;

    abstract static function getName() : string;

    abstract static function publishAssets() : void;
}