<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * إنشاء الأدوار وربطها بالصلاحيات الموجودة مسبقاً
     * Roles: 'مدير النظام', 'عميل'
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Get all permissions created by PermissionSeeder
        $permissions = Permission::all();

        // Create Roles with Arabic names
        $superAdminRole = Role::firstOrCreate(['name' => 'مدير النظام', 'guard_name' => 'web']);
        $clientRole = Role::firstOrCreate(['name' => 'عميل', 'guard_name' => 'web']);

        // Super Admin (مدير النظام) gets ALL permissions
        $superAdminRole->syncPermissions($permissions);
        $this->command->info('✓ Super Admin (مدير النظام): assigned all permissions');

        // Client (عميل) gets product CRUD (scoped to own in policy) + dashboard
        $clientPermissionNames = [
            'dashboard.view',
            'dashboard.statistics',
            'products.view-any',
            'products.view',
            'products.create',
            'products.update',
            'products.delete',
            'categories.view-any',
            'categories.view',
        ];

        $clientRole->syncPermissions($clientPermissionNames);
        $this->command->info('✓ Client (عميل): assigned ' . count($clientPermissionNames) . ' permissions (own products CRUD + dashboard)');
    }
}
