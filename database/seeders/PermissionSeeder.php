<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Permission;
use App\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionSeeder extends Seeder
{
    protected array $permissions = [
        // Project
        'project.view', 'project.create', 'project.update', 'project.delete', 'project.export',
        // Task
        'task.view', 'task.create', 'task.update', 'task.delete', 'task.assign',
        // Client
        'client.view', 'client.create', 'client.update', 'client.delete',
        // User
        'user.view', 'user.create', 'user.update', 'user.delete', 'user.assign_role',
        // Role & Permission
        'role.view', 'role.create', 'role.update', 'role.delete','manage.permissions',
        // Audit
        'audit.view', 'audit.export',
        // Excel
        'export.excel', 'import.excel',
    ];

    protected array $rolesPermissions = [
        'admin' => [
            'project.view', 'project.create', 'project.update', 'project.delete', 'project.export',
            'client.view',
            'task.view', 'task.create', 'task.update', 'task.delete', 'task.assign',
            'role.view', 'role.create', 'role.update', 'role.delete',
            'audit.view', 'audit.export',
            'export.excel', 'import.excel',
        ],
        'manager' => [
            'project.view', 'project.create', 'project.update', 'project.delete', 'project.export',
            'client.view',
            'task.view', 'task.create', 'task.update', 'task.delete', 'task.assign',
            'role.view', 'role.create', 'role.update', 'role.delete',
            'audit.view', 'audit.export',
            'export.excel', 'import.excel',
        ],
        'tim' => [
            'project.view', 'project.export',
            'task.view',
            'role.view', 'role.create', 'role.update', 'role.delete',
            'audit.view', 'audit.export',
            'export.excel', 'import.excel',
        ],
    ];

    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        foreach ($this->permissions as $name) {
            Permission::firstOrCreate([
                'name' => $name,
                'guard_name' => 'web',
            ]);
        }

        foreach ($this->rolesPermissions as $roleName => $permissionList) {
            $role = Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);

            $role->syncPermissions($permissionList);
        }

        app(PermissionRegistrar::class)->forgetCachedPermissions();
    }
}

