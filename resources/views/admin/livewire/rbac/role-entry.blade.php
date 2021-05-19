<tr>
    <th scope="row">{{ $role->name }}</th>
    <td class="text-end">
        <livewire:sqms-foundation.admin.rbac.members-role :role="$role" />
        <livewire:sqms-foundation.admin.rbac.edit-role :role="$role" />
        <livewire:sqms-foundation.admin.rbac.delete-role :role="$role" />
    </td>
</tr>