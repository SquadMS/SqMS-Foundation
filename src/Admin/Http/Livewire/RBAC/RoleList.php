<?php

namespace SquadMS\Foundation\Admin\Http\Livewire\RBAC;

use Livewire\Component;
use Livewire\WithPagination;
use Spatie\Permission\Models\Role;

class RoleList extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = [
        'role:created' => '$refresh',
        'role:deleted' => '$refresh',
    ];

    public function render()
    {
        return view('sqms-foundation::admin.livewire.rbac.role-list', [
            'roles' => Role::paginate(10),
        ]);
    }
}
