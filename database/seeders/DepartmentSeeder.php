<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\Department;
class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            [
                'name' => 'Software Development',
                'code' => 'SOFTWARE_DEVELOPMENT',
                'description' => 'Backend and frontend software development team'
            ],
            [
                'name' => 'Quality Assurance',
                'code' => 'QUALITY_ASSURANCE',
                'description' => 'Software testing and quality assurance team',
            ],

            [
                'name' => 'UI UX Design',
                'code' => 'UI_UX_DESIGN',
                'description' => 'User interface and user experience design team',
            ],

            [
                'name' => 'Technical Support',
                'code' => 'TECHNICAL_SUPPORT',
                'description' => 'Customer and technical support team',
            ],

            [
                'name' => 'DevOps',
                'code' => 'DEVOPS',
                'description' => 'Infrastructure and deployment management team',
            ],

            [
                'name' => 'Business Analysis',
                'code' => 'BUSINESS_ANALYSIS',
                'description' => 'Requirement gathering and business analysis team',
            ],

            [
                'name' => 'Project Management',
                'code' => 'PROJECT_MANAGEMENT',
                'description' => 'Project planning and management team',
            ],
        ];

       foreach ($departments as $department) {
            Department::updateOrCreate(
                [
                    'code' => $department['code']
                ],
                $department
            );
        }
    }
}
