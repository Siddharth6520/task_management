<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Documents\Module;
use Doctrine\ODM\MongoDB\DocumentManager;

class ModuleSeeder extends Seeder
{
    public function run(): void
    {
        $dm = app(DocumentManager::class);

        $repo = $dm->getRepository(Module::class);

        $modules = [
            [
                'name' => 'Project',
                'code' => 'PROJECT',
                'description' => 'Project module',
            ],
            [
                'name' => 'Task',
                'code' => 'TASK',
                'description' => 'Task module',
            ],
            [
                'name' => 'User',
                'code' => 'USER',
                'description' => 'User module',
            ],
        ];

        foreach ($modules as $moduleData) {

            $module = $repo->findOneBy([
                'code' => $moduleData['code']
            ]) ?? new Module();

            $module
                ->setName($moduleData['name'])
                ->setCode($moduleData['code'])
                ->setDescription($moduleData['description']);

            $dm->persist($module);
        }

        $dm->flush();
    }
}