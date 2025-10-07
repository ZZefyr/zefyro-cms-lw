<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Core\Models\User;
use Illuminate\Support\Facades\Hash;

class RolePermissionSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Vytvoř oprávnění
        $permissions = [
            // Uživatelé
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Články
            'view posts',
            'create posts',
            'edit posts',
            'delete posts',
            'publish posts',

            // Kategorie
            'manage categories',

            // Nastavení
            'manage settings',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Vytvoř role a přiřaď oprávnění

        // Super Admin - všechna oprávnění
        $superAdmin = Role::create(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        // Admin - skoro všechno
        $admin = Role::create(['name' => 'admin']);
        $admin->givePermissionTo([
            'view users', 'create users', 'edit users',
            'view posts', 'create posts', 'edit posts', 'delete posts', 'publish posts',
            'manage categories',
        ]);

        // Editor - práce s obsahem
        $editor = Role::create(['name' => 'editor']);
        $editor->givePermissionTo([
            'view posts', 'create posts', 'edit posts', 'publish posts',
            'manage categories',
        ]);

        // Writer - jen psaní
        $writer = Role::create(['name' => 'writer']);
        $writer->givePermissionTo([
            'view posts', 'create posts', 'edit posts',
        ]);

        // Vytvoř testovací uživatele
        $superAdminUser = User::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@example.com',
            'password' => Hash::make('password'),
        ]);
        $superAdminUser->assignRole('super-admin');

        $adminUser = User::create([
            'name' => 'Admin',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
        ]);
        $adminUser->assignRole('admin');

        $editorUser = User::create([
            'name' => 'Editor',
            'email' => 'editor@example.com',
            'password' => Hash::make('password'),
        ]);
        $editorUser->assignRole('editor');

        $writerUser = User::create([
            'name' => 'Writer',
            'email' => 'writer@example.com',
            'password' => Hash::make('password'),
        ]);
        $writerUser->assignRole('writer');
    }
}
