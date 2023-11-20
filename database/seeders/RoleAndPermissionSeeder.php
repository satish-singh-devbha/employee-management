<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create(['name' => 'All']);
        
        $adminRole = Role::create(['name' => 'Admin']);
        $employeeRole = Role::create(['name' => 'Employee']);

        $adminRole->givePermissionTo([
            'All',
        ]);

        $employeeRole->givePermissionTo([
            'All',
        ]);

        $user = User::create([
            "name" => "admin",
            "email" => "admin@admin.com",
            "password" => Hash::make(12345678),
            "employee_id" => "emp_1"
        ]);

        $user->assignRole('Admin');
    }
}
