<?php

namespace SquadMS\Foundation\Settings;

use Spatie\LaravelSettings\Settings;

class SettingsManager
{
    private array $settings = [];

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function register(Settings $settings): void
    {
        $this->settings[] = $settings;
    }
}