<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * إنشاء مستخدم مسؤول افتراضي
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            [
                'email' => 'admin@admin.com',

                'email_verified_at' => now(),
                'phone' => '1234567890',
                'is_active' => true,
                'name' => 'مدير النظام',
                'password' => Hash::make('password'),
            ]
        );

        // Assign admin role
        $admin->assignRole('مدير النظام');
    }
}
