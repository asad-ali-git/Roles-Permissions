<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        try {
            DB::beginTransaction();

            $superAdminRole = Role::withoutGlobalScopes()->where('name', Role::ROLE_SUPER_ADMIN)->first();
            if ($superAdminRole) {
                $user = User::where('email', User::SUPER_ADMIN_EMAIL)->first();
                if (!$user) {
                    User::factory()->create([
                        'name' => User::SUPER_ADMIN_NAME,
                        'email' => User::SUPER_ADMIN_EMAIL,
                        'role_id' => $superAdminRole->id,
                    ]);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e);
            throw $e;
        }
    }
}
