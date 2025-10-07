<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Core\Models\User;

class RoleSeeder extends Seeder
{
    public function run()
    {
        // Přiřaď roli uživateli
        $user = User::where('email', 'superadmin@example.com')->first();
        if ($user) {
            $user->assignRole('super-admin');
        }
    }
}
