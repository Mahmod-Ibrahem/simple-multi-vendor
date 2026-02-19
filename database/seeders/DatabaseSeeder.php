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
        $this->call([
            PermissionSeeder::class,
            RoleSeeder::class,
            AdminUserSeeder::class,
            CategorySeeder::class,
            SubjectSeeder::class,
            AssignmentSeeder::class,
            LetterStatusSeeder::class, // Must run before LetterSeeder
            LetterSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
