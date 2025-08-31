<?php

namespace Database\Seeders;

use App\Models\Dashboard\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Admin::firstOrCreate([
            'email' => 'admin@admin.com',
        ], [
            'name'       => 'Admin',
            'password'   => Hash::make('123123123'),
            'roles_name' => 'admins',
            'status'     => '1',
        ]);

        // Ensure the admin has the proper role
        if (!$admin->hasRole('admin')) {
            $admin->assignRole('admin');
        }
    }
}
