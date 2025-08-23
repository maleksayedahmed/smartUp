<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // الصلاحيات الأساسية
        $permissions = ['الطلاب', 'اضافة طالب', 'تعديل طالب', 'حذف طالب','الصلاحيات','فريق النظام'];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission,'parent'=>0, 'guard_name' => 'web']);
        }

        // الدور الأساسي
        $adminRole = Role::firstOrCreate(['name' => 'admin', 'guard_name' => 'web']);

        // اربط الدور بالصلاحيات كلها
        $adminRole->syncPermissions($permissions);
    }
}
