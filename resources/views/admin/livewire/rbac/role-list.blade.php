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
                <livewire:sqms-foundation.admin.rbac.role-entry :role="$role" :key="$role->id"></livewire:sqms-foundation.admin.rbac.role-entry />
                @endforeach
            </tbody>
        </table>
    </div>

    {{ $roles->links() }}
    @else
    <p class="text-center">No Roles have been created yet.</p>
    @endif
</div>