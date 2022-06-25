<?php

namespace SquadMS\Foundation\Menu;

use Illuminate\Support\Facades\App;
use SquadMS\Foundation\Themes\Settings\ThemesNavigationsSettings;

class MenuManager
{
    public function get(string $handle): string
    {
        /** @var ThemesNavigationsSettings */
        $setting = App::resolve(ThemesNavigationsSettings::class);
        return json_encode($setting->slotHandles);
    }
}
