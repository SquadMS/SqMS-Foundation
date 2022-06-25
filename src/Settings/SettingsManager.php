<?php

namespace SquadMS\Foundation\Settings;

class SettingsManager
{
    private array $settings = [];

    public function getSettings(): array
    {
        return $this->settings;
    }

    public function register(string $settings): void
    {
        $this->settings[] = $settings;
    }
}