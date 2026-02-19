<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     * إنشاء جميع الصلاحيات مع الأسماء العربية والإنجليزية
     */
    public function run(): void
    {
        // Reset cached permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Define all permissions with English name and Arabic translation
        $permissions = [
            // Dashboard permissions - صلاحيات لوحة التحكم
            ['name' => 'dashboard.view', 'name_ar' => 'عرض لوحة التحكم'],
            ['name' => 'dashboard.statistics', 'name_ar' => 'عرض الإحصائيات'],
            ['name' => 'dashboard.calendar', 'name_ar' => 'عرض التقويم'],

            // User Management permissions - صلاحيات إدارة المستخدمين
            ['name' => 'users.view-any', 'name_ar' => 'عرض جميع المستخدمين'],
            ['name' => 'users.view', 'name_ar' => 'عرض مستخدم'],
            ['name' => 'users.create', 'name_ar' => 'إنشاء مستخدم'],
            ['name' => 'users.update', 'name_ar' => 'تعديل مستخدم'],
            ['name' => 'users.toggle-active', 'name_ar' => 'تفعيل/تعطيل مستخدم'],
            ['name' => 'users.delete', 'name_ar' => 'حذف مستخدم'],

            // Letters permissions - صلاحيات الكتب
            ['name' => 'letters.view-any', 'name_ar' => 'عرض جميع الكتب'],
            ['name' => 'letters.view', 'name_ar' => 'عرض كتاب'],
            ['name' => 'letters.create', 'name_ar' => 'إنشاء كتاب'],
            ['name' => 'letters.update', 'name_ar' => 'تعديل كتاب'],
            ['name' => 'letters.delete', 'name_ar' => 'حذف كتاب'],
            ['name' => 'letters.statistics', 'name_ar' => 'إحصائيات الكتب'],

            // Categories permissions - صلاحيات التصنيفات
            ['name' => 'categories.view-any', 'name_ar' => 'عرض جميع التصنيفات'],
            ['name' => 'categories.view', 'name_ar' => 'عرض تصنيف'],
            ['name' => 'categories.create', 'name_ar' => 'إنشاء تصنيف'],
            ['name' => 'categories.update', 'name_ar' => 'تعديل تصنيف'],
            ['name' => 'categories.delete', 'name_ar' => 'حذف تصنيف'],

            // Subjects permissions - صلاحيات المواضيع
            ['name' => 'subjects.view-any', 'name_ar' => 'عرض جميع المواضيع'],
            ['name' => 'subjects.view', 'name_ar' => 'عرض موضوع'],
            ['name' => 'subjects.create', 'name_ar' => 'إنشاء موضوع'],
            ['name' => 'subjects.update', 'name_ar' => 'تعديل موضوع'],
            ['name' => 'subjects.delete', 'name_ar' => 'حذف موضوع'],

            // Assignments permissions - صلاحيات التكليفات
            ['name' => 'assignments.view-any', 'name_ar' => 'عرض جميع التكليفات'],
            ['name' => 'assignments.view', 'name_ar' => 'عرض تكليف'],
            ['name' => 'assignments.create', 'name_ar' => 'إنشاء تكليف'],
            ['name' => 'assignments.update', 'name_ar' => 'تعديل تكليف'],
            ['name' => 'assignments.delete', 'name_ar' => 'حذف تكليف'],

            // Employees permissions - صلاحيات الموظفين
            ['name' => 'employees.view-any', 'name_ar' => 'عرض جميع الموظفين'],
            ['name' => 'employees.view', 'name_ar' => 'عرض موظف'],
            ['name' => 'employees.create', 'name_ar' => 'إنشاء موظف'],
            ['name' => 'employees.update', 'name_ar' => 'تعديل موظف'],
            ['name' => 'employees.delete', 'name_ar' => 'حذف موظف'],

            // Letter Statuses permissions - صلاحيات حالات الكتب
            ['name' => 'letter-statuses.view-any', 'name_ar' => 'عرض جميع حالات الكتب'],
            ['name' => 'letter-statuses.view', 'name_ar' => 'عرض حالة كتاب'],
            ['name' => 'letter-statuses.create', 'name_ar' => 'إنشاء حالة كتاب'],
            ['name' => 'letter-statuses.update', 'name_ar' => 'تعديل حالة كتاب'],
            ['name' => 'letter-statuses.delete', 'name_ar' => 'حذف حالة كتاب'],


            // RBAC permissions (Super Admin only) - صلاحيات الأدوار والصلاحيات
            ['name' => 'roles.view-any', 'name_ar' => 'عرض جميع الأدوار'],
            ['name' => 'roles.view', 'name_ar' => 'عرض دور'],
            ['name' => 'roles.create', 'name_ar' => 'إنشاء دور'],
            ['name' => 'roles.update', 'name_ar' => 'تعديل دور'],
            ['name' => 'roles.delete', 'name_ar' => 'حذف دور'],
            ['name' => 'roles.sync-permissions', 'name_ar' => 'مزامنة صلاحيات الدور'],
            ['name' => 'permissions.view-any', 'name_ar' => 'عرض جميع الصلاحيات'],
            ['name' => 'permissions.view', 'name_ar' => 'عرض صلاحية'],
            ['name' => 'permissions.create', 'name_ar' => 'إنشاء صلاحية'],
            ['name' => 'permissions.update', 'name_ar' => 'تعديل صلاحية'],
            ['name' => 'permissions.delete', 'name_ar' => 'حذف صلاحية'],
        ];

        // Create all permissions with 'api' guard
        foreach ($permissions as $permissionData) {
            Permission::updateOrCreate(
                [
                    'name' => $permissionData['name'],
                    'guard_name' => 'api'
                ],
                [
                    'name_ar' => $permissionData['name_ar']
                ]
            );
        }

        $this->command->info('✓ Created/Updated ' . count($permissions) . ' permissions with Arabic names');
    }

    /**
     * Get all permission names (for use in RoleSeeder)
     */
    public static function getAllPermissionNames(): array
    {
        return [
            'dashboard.view',
            'dashboard.statistics',
            'dashboard.calendar',
            'users.view-any',
            'users.view',
            'users.create',
            'users.update',
            'users.toggle-active',
            'letters.view-any',
            'letters.view',
            'letters.create',
            'letters.update',
            'letters.delete',
            'letters.statistics',
            'categories.view-any',
            'categories.view',
            'categories.create',
            'categories.update',
            'categories.delete',
            'subjects.view-any',
            'subjects.view',
            'subjects.create',
            'subjects.update',
            'subjects.delete',
            'assignments.view-any',
            'assignments.view',
            'assignments.create',
            'assignments.update',
            'assignments.delete',
            'employees.view-any',
            'employees.view',
            'employees.create',
            'employees.update',
            'employees.delete',
            'letter-statuses.view-any',
            'letter-statuses.view',
            'letter-statuses.create',
            'letter-statuses.update',
            'letter-statuses.delete',

            'roles.view-any',
            'roles.view',
            'roles.create',
            'roles.update',
            'roles.delete',
            'roles.sync-permissions',
            'permissions.view-any',
            'permissions.view',
            'permissions.create',
            'permissions.update',
            'permissions.delete',
        ];
    }
}
