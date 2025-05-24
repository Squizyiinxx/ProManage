<?php

namespace App\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Inertia\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Validation\Rule;
use Spatie\Activitylog\Models\Activity;
use App\Services\Audit\RoleAuditService;
use Inertia\Inertia;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::with('permissions')->paginate(10);
        $permissions = Permission::all();
        return Inertia::render('Roles', [
            'roles' => $roles,
            'permissions' => $permissions,
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|unique:roles,name',
        ]);

        Role::create([
            'name' => $validated['name'],
        ]);

        return redirect()->back()->with('success', 'Role created.');
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $role = Role::findOrFail($id);

        $validated = $request->validate([
            'name' => [
                'required',
                Rule::unique('roles', 'name')->ignore($role->uuid, 'uuid'),
            ],
        ]);

        $role->update([
            'name' => $validated['name'],
        ]);

        return redirect()->route('roles')->with('success', 'Role updated successfully.');
    }

    public function assignPermissions(Request $request, string $roleId): RedirectResponse
    {
        $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'uuid|exists:permissions,uuid',
        ]);

        $role = Role::findOrFail($roleId);
        $permissions = $request->input('permissions', []);

        $previousPermissions = $role->permissions->pluck('uuid')->toArray();
        $role->syncPermissions($permissions);

        app(RoleAuditService::class)->logPermissionChange($role, $previousPermissions, $permissions);

        return redirect()->back()->with('success', 'Permissions updated.');
    }
    public function auditTrail(Request $request): Response
    {
        $activities = Activity::with(['causer', 'subject'])
        ->where('subject_type', Role::class)
        ->latest()
        ->paginate(10)
        ->through(function ($activity) {
            return [
                'event' => ucfirst($activity->description),
                'user' => optional($activity->causer)->name ?? 'System',
                'description' => $activity->properties['note']
                    ?? optional($activity->subject)->name
                    ?? '-',
                'date' => $activity->created_at->format('Y-m-d H:i:s'),
            ];
        })
        ->withQueryString();

        return Inertia::render('Role/History', [
            'auditTrail' => $activities,
        ]);
    }

    public function destroy(Request $request, string $id): RedirectResponse
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect()->route('roles')->with('success', 'Role deleted successfully.');
    }
}
