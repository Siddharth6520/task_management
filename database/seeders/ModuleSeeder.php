<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [

            [
                'name' => 'Tasks',
                'code' => 'TASKS',
                'description' => 'Task management module    '
            ],

            [
                'name' => 'Projects',
                'code' => 'PROJECTS',
                'description' => 'Project management module'
            ],

            [
                'name' => 'Users',
                'code' => 'USERS',
                'description' => 'User management module'
            ],

            [
                'name' => 'Workflows',
                'code' => 'WORKFLOWS',
                'description' => 'Workflow management module'
            ],

            [
                'name' => 'Reports',
                'code' => 'REPORTS',
                'description' => 'Reports and analytics module'
            ],

        ];

        foreach ($modules as $module) {

            Module::updateOrCreate(
                [
                    'code' => $module['code']
                ],
                $module
            );
        }

    }
}