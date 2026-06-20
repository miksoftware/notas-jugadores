<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        $permissions = [
            'users.view', 'users.create', 'users.edit', 'users.delete',
            'notes.view', 'notes.create', 'notes.edit', 'notes.delete',
            'players.view', 'players.create', 'players.edit', 'players.delete'
        ];

        foreach ($permissions as $perm) {
            Permission::firstOrCreate(['name' => $perm]);
        }

        // create roles and assign created permissions
        $roleAgent = Role::firstOrCreate(['name' => 'Support Agent']);
        $roleAgent->syncPermissions(['players.view', 'notes.view', 'notes.create']);

        $roleAdmin = Role::firstOrCreate(['name' => 'Admin']);
        $roleAdmin->syncPermissions(Permission::all());

        // Create an initial Admin user
        $admin = User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => 'Admin User',
                'password' => bcrypt('123admin')
            ]
        );
        $admin->assignRole('Admin');
    }
}
