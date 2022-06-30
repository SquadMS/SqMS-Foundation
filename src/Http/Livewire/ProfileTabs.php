<?php

namespace SquadMS\Foundation\Http\Livewire;

use Livewire\Component;
use SquadMS\Foundation\Facades\SquadMSProfile;
use SquadMS\Foundation\Models\SquadMSUser;
use SquadMS\Foundation\Profile\ProfileTab;

class ProfileTabs extends Component
{
    public SquadMSUser $user;

    public string $tab;

    public array $tabs;

    public function mount(?string $tab = null)
    {
        $this->tabs = collect(SquadMSProfile::getTabs())->mapWithKeys(fn (ProfileTab $tab) => [$tab->name => $tab->label()])->toArray();
        $this->setTab($tab ?? head(array_keys($this->tabs)));
    }

    public function setTab(string $tab)
    {
        if (in_array($tab, array_keys($this->tabs))) {
            $this->tab = $tab;
        }
    }

    public function render()
    {
        $component = $this->currentTab()->component;

        return view('sqms-foundation::livewire.profile-tabs', [
            'component' => $this->currentTab()->component,
        ]);
    }

    private function currentTab(): ProfileTab
    {
        /** @var ProfileTab Fix for IntellSense */
        $tab = collect(SquadMSProfile::getTabs())->filter(fn (ProfileTab $tab) => $tab->name === $this->tab)->firstOrFail();

        return $tab;
    }
}
