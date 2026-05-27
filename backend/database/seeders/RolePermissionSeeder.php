<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Documents\Role;
use App\Documents\Permission;
use App\Documents\RolePermission;

use Doctrine\ODM\MongoDB\DocumentManager;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        $dm = app(DocumentManager::class);

        $roleRepo = $dm->getRepository(Role::class);
        $permissionRepo = $dm->getRepository(Permission::class);
        $rolePermissionRepo = $dm->getRepository(RolePermission::class);

        $superAdmin = $roleRepo->findOneBy([
            'code' => 'SUPER_ADMIN'
        ]);

        if (!$superAdmin) {
            throw new \Exception(
                "SUPER_ADMIN role not found"
            );
        }

        $permissions = $permissionRepo->findAll();

        foreach ($permissions as $permission) {

            $exists = $rolePermissionRepo->findOneBy([
                'role' => $superAdmin,
                'permission' => $permission
            ]);

            if ($exists) {
                continue;
            }

            $rolePermission = new RolePermission();

            $rolePermission->setRole(
                $superAdmin
            );

            $rolePermission->setPermission(
                $permission
            );

            $dm->persist(
                $rolePermission
            );
        }

        $dm->flush();
    }
}