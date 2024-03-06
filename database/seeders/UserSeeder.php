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
                $user = User::where('email', 'admin@gmail.com')->first();
                if (!$user) {
                    User::factory()->create([
                        'name' => 'Admin',
                        'email' => 'admin@gmail.com',
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
