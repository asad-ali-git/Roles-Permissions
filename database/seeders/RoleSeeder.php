<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $superAdminRole = Role::where('name', Role::ROLE_SUPER_ADMIN)->first();
            if (! $superAdminRole) {
                Role::factory()->create();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }
    }
}
