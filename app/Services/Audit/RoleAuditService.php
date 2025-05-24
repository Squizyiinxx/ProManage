<?php

namespace App\Services\Audit;

use App\Models\Role;
use App\Models\Permission;

class RoleAuditService
{
    public function logPermissionChange(Role $role, array $before, array $after): void
    {
        $added = array_diff($after, $before);
        $removed = array_diff($before, $after);

        $addedNames = Permission::whereIn('uuid', $added)->pluck('name')->toArray();
        $removedNames = Permission::whereIn('uuid', $removed)->pluck('name')->toArray();

        $description = 'Updated permissions for Role "' . $role->name . '"';
        if (!empty($addedNames)) {
            $description .= ': added [' . implode(', ', $addedNames) . ']';
        }
        if (!empty($removedNames)) {
            $description .= (!empty($addedNames) ? ', ' : ': ') . 'removed [' . implode(', ', $removedNames) . ']';
        }

        activity('role')
            ->performedOn($role)
            ->causedBy(auth()->user())
            ->withProperties([
                'note' => $description,
                'added' => $addedNames,
                'removed' => $removedNames,
            ])
            ->log('permissions_updated');
    }
}
