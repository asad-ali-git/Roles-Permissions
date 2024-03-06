<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // SEEDERS SEQUENCE MATTERS HERE SO BE CAREFUL :)

        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
    }
}
