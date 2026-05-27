<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Documents\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $dm = app(DocumentManager::class);
        $repo = $dm->getRepository(Department::class);

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

        foreach ($departments as $departmentData) {

            $department = $repo->findOneBy([
                'code' => $departmentData['code']
            ]) ?? new Department();

            $department
                ->setName($departmentData['name'])
                ->setCode($departmentData['code'])
                ->setDescription($departmentData['description']);

            $dm->persist($department);
        }

        $dm->flush();
    }
}
