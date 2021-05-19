<?php

namespace SquadMS\Foundation\Admin\Http\Livewire\RBAC;

use Spatie\Permission\Models\Role;
use SquadMS\Foundation\Admin\Http\Livewire\Contracts\AbstractModalComponent;

class DeleteRole extends AbstractModalComponent
{
    public Role $role;

    public function deleteRole() {
        /* Delete the Role */
        $this->role->delete();    
        
        /* Hide the modal (backdrop) */
        $this->hideModal();

        /* Emit event */
        $this->emit('role:deleted');
    }
    
    public function render()
    {
        return view('sqms-foundation::admin.livewire.rbac.delete-role');
    }
}