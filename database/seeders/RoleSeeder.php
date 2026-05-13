<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [
                'name' => 'Super Admin',
                'code' => 'SUPER_ADMIN',
                'description' => 'Full system access',
            ],
            [
                'name' => 'Project Manager',
                'code' => 'PROJECT_MANAGER',
                'description' => 'Project management access',
            ],
            [
                'name' => 'Manager',
                'code' => 'MANAGER',
                'description' => 'Department management access',
            ],
            [
                'name' => 'Team Lead',
                'code' => 'TEAM_LEAD',
                'description' => 'Team lead access',
            ],
            [
                'name' => 'Employee',
                'code' => 'EMPLOYEE',
                'description' => 'Basic employee access',
            ],
        ];

        Role::insert($roles);
    }
}
