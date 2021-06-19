<div>
    @if ($roles->count())
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Role</th>
                        <th class="text-end">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $role)
                    <tr>
                        <td scope="row">{{ $role->name }}</td>
                        <td class="text-end">
                            <x-sqms-foundation::button class="btn-primary" wire:click="$toggle('showMembersModal')" wire:loading.attr="disabled">
                                Members
                            </x-sqms-foundation::button>
                            <x-sqms-foundation::button class="btn-warning" wire:click="$toggle('showEditModal')" wire:loading.attr="disabled">
                                Edit
                            </x-sqms-foundation::button>
                            <x-sqms-foundation::button class="btn-danger" wire:click="$toggle('showDeleteModal')" wire:loading.attr="disabled">
                                Delete
                            </x-sqms-foundation::button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{ $roles->links() }}

        @if ($selectedRole)
            <x-sqms-foundation::dialog-modal model="showMembersModal" maxWidth="xl" fullscreen="xl">
                <x-slot name="title">
                    Role Members
                </x-slot>
            
                <x-slot name="content">
                    <div class="input-group mb-3">
                        <livewire:sqms-foundation.admin.rbac.new-member-search name="newMember" :searchable="true" :key="$searchInstance" :role="$role" />
                        <button class="btn btn-outline-primary" type="button" wire:click="addMember">Add</button>
                    </div>

                    <hr>

                    <div>
                        @if ($users->count())
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">User</th>
                                        <th class="text-end">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td class="text-end">
                                                <button class="btn btn-secondary" type="button" wire:click="removeMember('{{ $user->id }}', true)">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        {{ $users->links() }}
                        @else
                        <p class="text-center mb-0">This Role does not have any members.</p>
                        @endif
                    </div>
                </x-slot>
            
                <x-slot name="footer">
                    <div class="flex-grow-1"></div>

                    <x-sqms-foundation::button class="btn-dark" wire:click="$set('showMembersModal', false)" wire:loading.attr="disabled">
                        Close
                    </x-sqms-foundation::button>
                </x-slot>
            </x-sqms-foundation::dialog-modal>

            <x-sqms-foundation::dialog-modal model="showEditModal" maxWidth="xl" fullscreen="xl">
                <x-slot name="title">
                    Edit Role
                </x-slot>
            
                <x-slot name="content">
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Role name</label>

                        <div class="input-group">
                            <input type="text" class="form-control" placeholder="Name of the role" aria-label="Name of the role" value="{{ $role->name }}" wire:model.lazy="role.name">
                            <x-sqms-foundation::button class="btn-outline-success" wire:click="updateRole" wire:loading.attr="disabled">
                                Update
                            </x-sqms-foundation::button>
                        </div>
                    </div>

                    <hr>
                    
                    <div>
                        @foreach (\SquadMSPermissions::getModules() as $module)
                        <div class="border border-primary mb-3">
                            <div class="p-3 bg-primary text-white">
                                <h3>{{ $module }}</h3>
                            </div>
                            <div class="p-3">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th scope="col">Permission</th>
                                                <th class="text-end">Allowed</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach (\SquadMSPermissions::getPermissions($module) as $definition => $displayName)
                                                <tr>
                                                    <td>{{ $displayName }}</td>
                                                    <td class="text-end">
                                                        @if ($role->hasPermissionTo($definition))
                                                            <button class="btn btn-primary" type="button" wire:click="togglePermission('{{ $definition }}', false)">
                                                                <i class="bi bi-check"></i>
                                                            </button>
                                                        @else
                                                            <button class="btn btn-secondary" type="button" wire:click="togglePermission('{{ $definition }}', true)">
                                                                <i class="bi bi-x"></i>
                                                            </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </x-slot>
            
                <x-slot name="footer">
                    <x-sqms-foundation::button class="btn-dark" wire:click="$set('showEditModal', false)" wire:loading.attr="disabled">
                        Close
                    </x-sqms-foundation::button>
            
                    <div class="flex-grow-1"></div>
                </x-slot>
            </x-sqms-foundation::dialog-modal>
            
            <x-sqms-foundation::confirm-modal model="showDeleteModal">
                <x-slot name="title">
                    Delete Role
                </x-slot>
            
                <x-slot name="content">
                    <p>Are you sure that you want to delete the Role?</p>
                </x-slot>
            
                <x-slot name="footer">
                    <x-sqms-foundation::button class="btn-dark" wire:click="$set('showDeleteModal', false)" wire:loading.attr="disabled">
                        Cancel
                    </x-sqms-foundation::button>
            
                    <div class="flex-grow-1"></div>

                    <x-sqms-foundation::button class="btn-danger" wire:click="deleteRole" wire:loading.attr="disabled">
                        Delete
                    </x-sqms-foundation::button>
                </x-slot>
            </x-sqms-foundation::confirm-modal>
        @endif
    @else
        <p class="text-center">No Roles have been created yet.</p>
    @endif
</div>