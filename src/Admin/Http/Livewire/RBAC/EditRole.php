<?php

namespace SquadMS\Foundation\Admin\Http\Livewire\RBAC;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Spatie\Permission\Models\Role;
use SquadMS\Foundation\Admin\Http\Livewire\Contracts\AbstractModalComponent;

class EditRole extends AbstractModalComponent
{
    use AuthorizesRequests;

    public Role $role;

    protected $rules = [
        'role.name' => null // TODO: Remove this somehow...
    ];

    public function updateRole() {
        /* Authorize the action */
        $this->authorize('update', $this->role);

        /* Validate the data first */
        $this->validate([
            'role.name' => 'required|string|unique:Spatie\Permission\Models\Role,name,' . $this->role->id,
        ]);
        
        /* Create the Role */
        $this->role->save();

        $this->hideModal();

        /* Emit event */
        $this->emitUp('role:updated');
    }

    public function togglePermission(string $definition, bool $state) {
        if ($state) {
            $this->role->givePermissionTo($definition);
        } else {
            $this->role->revokePermissionTo($definition);
        }
    }
    
    public function render()
    {
        return view('sqms-foundation::admin.livewire.rbac.edit-role');
    }
}