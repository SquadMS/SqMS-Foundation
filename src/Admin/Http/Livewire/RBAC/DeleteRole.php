<?php

namespace SquadMS\Foundation\Admin\Http\Livewire\RBAC;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Models\Role;
use SquadMS\Foundation\Admin\Http\Livewire\Contracts\AbstractModalComponent;

class DeleteRole extends AbstractModalComponent
{
    use AuthorizesRequests;

    public Role $role;

    public function deleteRole()
    {
        /* Authorize the action */
        $this->authorize('delete', $this->role);

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
