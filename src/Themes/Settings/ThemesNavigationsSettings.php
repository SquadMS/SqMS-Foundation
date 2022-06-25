<?php

namespace SquadMS\Foundation\Themes\Settings;

use Illuminate\Support\Str;
use Spatie\LaravelSettings\Settings;

class ThemesNavigationsSettings extends Settings
{   
    public array $slotHandles;
    
    public static function group(): string
    {
        return Str::camel(last(explode('\\', __CLASS__)));
    }
}