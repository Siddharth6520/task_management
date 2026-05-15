<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Permission;
use App\Models\Module;
use App\Models\Action;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = Module::all();
        $actions = Action::all();

        $permissions = [];

        foreach ($modules as $module) {

            foreach ($actions as $action) {

                $permissions[] = [

                    'module_id' => $module->_id,
                    'action_id' => $action->_id,

                    'name' =>
                        ucfirst(strtolower($module->name)) . ' ' .
                        ucfirst(strtolower($action->name)),

                    'code' =>
                        strtoupper($module->code . '_' . $action->code),

                    'description' =>
                        "Permission to {$action->name} {$module->name}",

                    'is_active' => true,
                ];
            }
        }

        foreach ($permissions as $permission) {

            Permission::updateOrCreate(
                [
                    'code' => $permission['code']
                ],
                $permission
            );
        }
    }
}