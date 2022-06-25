<?php

use Spatie\LaravelSettings\Migrations\SettingsBlueprint;
use Spatie\LaravelSettings\Migrations\SettingsMigration;
use SquadMS\Foundation\Settings\ThemesNavigationsSettings;

return new class extends SettingsMigration
{
    public function up(): void
    {
        $this->migrator->inGroup(ThemesNavigationsSettings::group(), function (SettingsBlueprint $migrator) {
            $migrator->add('slotHandles', 'laravel-settings');
        });
    }
};