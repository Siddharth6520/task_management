<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

use App\Models\Action;


class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $actions = [
            ['name' => 'Create', 'code'=>'CREATE', 'description' => 'Create records'],
            ['name' => 'Read', 'code'=>'READ', 'description' => 'Read records'],
            ['name' => 'Update', 'code'=>'UPDATE', 'description' => 'Update records'],
            ['name' => 'Delete', 'code'=>'DELETE', 'description' => 'Delete records'],  
        ];

        foreach ($actions as $action) {

            Action::updateOrCreate(
                [
                    'code' => $action['code']
                ],
                $action
            );
        }
    }
}
