<?php

namespace SquadMS\Foundation\Http\Livewire;

use Livewire\Component;
use SquadMS\Foundation\Models\SquadMSUser;

class ProfileTabAbout extends Component
{
    public SquadMSUser $user;

    public function render()
    {
        return view('sqms-foundation::livewire.profile-tab-about');
    }
}
