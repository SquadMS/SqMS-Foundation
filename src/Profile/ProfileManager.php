<?php

namespace SquadMS\Foundation\Profile;

class ProfileManager
{
    private array $tabs;

    public function addTab(ProfileTab $tab): void
    {
        $this->tabs[] = $tab;
    }

    public function getTabs(): array
    {
        return $this->tabs;
    }
}
