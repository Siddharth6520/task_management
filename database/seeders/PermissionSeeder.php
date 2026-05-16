<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Documents\Action;
use App\Documents\Module;
use App\Documents\Permission;

use Doctrine\ODM\MongoDB\DocumentManager;

class PermissionSeeder extends Seeder
{
    public function run(): void
    {
        $dm = app(DocumentManager::class);

        $moduleRepo = $dm->getRepository(Module::class);
        $actionRepo = $dm->getRepository(Action::class);
        $permissionRepo = $dm->getRepository(Permission::class);

        $modules = $moduleRepo->findAll();
        $actions = $actionRepo->findAll();

        foreach ($modules as $module) {

            foreach ($actions as $action) {

                try {

                    $code = strtoupper(
                        $module->getCode() . '_' . $action->getCode()
                    );

                    $permission = $permissionRepo->findOneBy([
                        'code' => $code
                    ]) ?? new Permission();

                    $permission->setModule($module);

                    $permission->setAction($action);

                    $permission->setName(
                        ucfirst(strtolower($module->getName()))
                        . ' ' .
                        ucfirst(strtolower($action->getName()))
                    );

                    $permission->setCode($code);

                    $permission->setDescription(
                        "Permission to {$action->getName()} {$module->getName()}"
                    );

                    $permission->setIsActive(true);

                    $dm->persist($permission);

                } catch (\Throwable $e) {

                    \Log::error(
                        'PermissionSeeder failed',
                        [
                            'module' => $module->getCode(),
                            'action' => $action->getCode(),
                            'exception' => $e->getMessage()
                        ]
                    );

                    throw $e;
                }
            }
        }

        $dm->flush();
    }
}