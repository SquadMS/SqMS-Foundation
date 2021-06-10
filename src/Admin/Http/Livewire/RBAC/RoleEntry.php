<?php

namespace SquadMS\Foundation\Admin\Http\Livewire\RBAC;

use Livewire\Component;
use Spatie\Permission\Models\Role;

class RoleEntry extends Component
{
    public Role $role;

    protected $listeners = [
        'role:updated' => '$refresh',
    ];

    public function render()
    {
        return view('sqms-foundation::admin.livewire.rbac.role-entry');
    }
}
