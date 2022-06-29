<?php

namespace SquadMS\Foundation\Http\Livewire;

use Livewire\Component;
use SquadMS\Foundation\Models\SquadMSUser;

class ProfileTabs extends Component
{
    public SquadMSUser $user;

    public array $tabs;

    public string $tab = 'about';

    public function mount()
    {
        $this->tabs = [
            'about' => 'About content',
            'statistics' => 'Stats content'
        ] + [];
    }

    public function openTab(string $tab)
    {
        if (in_array($tab, array_keys($this->tabs))) {
            $this->tab = $tab;
        }
    }

    public function render()
    {
        return view('sqms-foundation::livewire.profile-tabs');
    }
}