<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::where('name', Role::ROLE_SUPER_ADMIN)->first();
        if ($superAdminRole) {
            $user = User::where('email', 'admin@gmail.com')->first();
            if (! $user) {
                User::factory()->create([
                    'name' => 'Admin',
                    'email' => 'admin@gmail.com',
                    'role_id' => $superAdminRole,
                ]);
            }
        }
    }
}
