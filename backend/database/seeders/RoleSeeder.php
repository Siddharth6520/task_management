<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Documents\Role;
use Doctrine\ODM\MongoDB\DocumentManager;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $dm = app(DocumentManager::class);

        $repo = $dm->getRepository(Role::class);

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

        foreach ($roles as $roleData) {

            try {

                $role = $repo->findOneBy([
                    'code' => $roleData['code']
                ]) ?? new Role();

                $role->setName($roleData['name']);
                $role->setCode($roleData['code']);
                $role->setDescription($roleData['description']);

                $dm->persist($role);

            } catch (\Throwable $e) {

                \Log::error(
                    'RoleSeeder failed',
                    [
                        'role' => $roleData['code'],
                        'exception' => $e->getMessage()
                    ]
                );

                throw $e;
            }
        }

        $dm->flush();
    }
}