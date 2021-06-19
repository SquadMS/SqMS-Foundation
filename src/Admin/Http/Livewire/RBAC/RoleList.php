<?php

namespace SquadMS\Foundation\Admin\Http\Livewire\RBAC;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;
use SquadMS\Foundation\Contracts\SquadMSUser;
use SquadMS\Foundation\Repositories\UserRepository;

class RoleList extends Component
{
    use AuthorizesRequests, WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'role:created' => '$refresh',
        'role:deleted' => '$refresh',
        'newMemberUpdated'   => 'selectUser',
        'role:memberAdded'   => '$refresh',
        'role:memberRemoved' => '$refresh',
    ];

    protected $rules = [
        'role.name' => null, // TODO: Remove this somehow...
    ];

    public Role $selectedRole;

    public string $searchInstance;
    public ?SquadMSUser $selectedUser;

    public function __construct($id = null)
    {
        parent::__construct($id);

        $this->searchInstance = Str::random();
        $this->selectedUser = null;
    }

    public function selectUser($data)
    {
        /* Authorize the action */
        $this->authorize('update', $this->role);

        $this->selectedUser = UserRepository::getUserModelQuery()->where('steam_id_64', $data['value'])->first();
    }

    public function addMember()
    {
        /* Authorize the action */
        $this->authorize('update', $this->selectedRole);

        if (is_null($this->selectedUser)) {
            return;
        }

        /* Remove the User from the Role */
        $this->selectedRole->users()->attach($this->selectedUser);

        $this->searchInstance = Str::random();
        $this->selectedUser = null;

        /* Fire the member added event */
        $this->emit('role:memberAdded');
    }

    public function removeMember($user)
    {
        /* Authorize the action */
        $this->authorize('update', $this->selectedRole);

        /* Remove the User from the Role */
        $this->selectedRole->users()->detach($user);

        /* Fire the member removed event */
        $this->emit('role:memberRemoved');
    }

    public function updateRole()
    {
        /* Authorize the action */
        $this->authorize('update', $this->selectedRole);

        /* Validate the data first */
        $this->validate([
            'role.name' => 'required|string|unique:Spatie\Permission\Models\Role,name,'.$this->selectedRole->id,
        ]);

        /* Create the Role */
        $this->selectedRole->save();

        $this->hideModal();

        /* Emit event */
        $this->emitUp('role:updated');
    }

    public function togglePermission(string $definition, bool $state)
    {
        if ($state) {
            $this->selectedRole->givePermissionTo($definition);
        } else {
            $this->selectedRole->revokePermissionTo($definition);
        }
    }

    public function deleteRole()
    {
        /* Authorize the action */
        $this->authorize('delete', $this->selectedRole);

        /* Delete the Role */
        $this->selectedRole->delete();

        /* Hide the modal (backdrop) */
        $this->hideModal();

        /* Emit event */
        $this->emit('role:deleted');
    }

    public function render()
    {
        return view('sqms-foundation::admin.livewire.rbac.role-list', [
            'roles' => Role::paginate(10),
            'users' => $this->selectedRole ? $this->selectedRole->users()->paginate(10) : null,
        ]);
    }
}
