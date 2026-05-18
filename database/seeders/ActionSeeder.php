<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Documents\Action;
use Doctrine\ODM\MongoDB\DocumentManager;

class ActionSeeder extends Seeder
{
    public function run(): void
    {
        $dm = app(DocumentManager::class);

        $repo = $dm->getRepository(Action::class);

        $actions = [
            [
                'name' => 'Create',
                'code' => 'CREATE',
                'description' => 'Create action',
            ],
            [
                'name' => 'Read',
                'code' => 'READ',
                'description' => 'Read action',
            ],
            [
                'name' => 'Update',
                'code' => 'UPDATE',
                'description' => 'Update action',
            ],
            [
                'name' => 'Delete',
                'code' => 'DELETE',
                'description' => 'Delete action',
            ],
        ];

        foreach ($actions as $actionData) {

            $action = $repo->findOneBy([
                'code' => $actionData['code']
            ]) ?? new Action();

            $action
                ->setName($actionData['name'])
                ->setCode($actionData['code'])
                ->setDescription($actionData['description']);

            $dm->persist($action);
        }

        $dm->flush();
    }
}