<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $superAdminRole = Role::where('name', Role::ROLE_SUPER_ADMIN)->first();
        if (! $superAdminRole) {
            Role::factory()->create();
        }
    }
}
