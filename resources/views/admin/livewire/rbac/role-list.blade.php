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

        <livewire:sqms-foundation.admin.rbac.members-role :role="$selectedRole" />
        <livewire:sqms-foundation.admin.rbac.edit-role :role="$selectedRole" />
        <livewire:sqms-foundation.admin.rbac.delete-role :role="$selectedRole" />
    @else
        <p class="text-center">No Roles have been created yet.</p>
    @endif
</div>