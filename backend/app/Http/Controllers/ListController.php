<?php

namespace App\Http\Controllers;

use App\Documents\Department;
use App\Documents\Role;
use App\Documents\Team;
use App\Documents\User;
use App\Documents\WorkFlowTemplate;
use App\Helpers\CommonHelper;
use Doctrine\ODM\MongoDB\DocumentManager;
use Illuminate\Http\Request;

class ListController extends Controller
{
    public function departments(DocumentManager $dm)
    {
        $departments = $dm->getRepository(Department::class)->findAll();
        $result = [];

        foreach ($departments as $department) {
            $result[] = [
                'id' => $department->getId(),
                'name' => $department->getName(),
                'code' => $department->getCode()
            ];
        }
        return CommonHelper::response(
            true,
            200,
            $result,
            "Department data retrieved successfully"
        );
    }

    public function roles(DocumentManager $dm)
    {
        $roles = $dm->getRepository(Role::class)->findAll();

        $result = [];

        foreach ($roles as $role) {
            $result[] = [
                'id' => $role->getId(),
                'name' => $role->getName(),
                'code' => $role->getCode()
            ];
        }
        return CommonHelper::response(
            true,
            200,
            $result,
            "Roles data retrieved successfully"
        );
    }

    public function users(DocumentManager $dm)
    {
        $users = $dm->getRepository(User::class)
            ->findBy([
                'is_active' => true
            ]);

        $result = [];

        foreach ($users as $user) {

            $result[] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'mobile' => $user->getMobileNo(),

                'role' => $user->getRole()
                    ? [
                        'id' => $user->getRole()->getId(),
                        'name' => $user->getRole()->getName()
                    ]
                    : null
            ];
        }

        return CommonHelper::response(
            true,
            200,
            $result,
            "Users data retrieved successfully"
        );
    }


    public function teams(DocumentManager $dm)
    {
        $teams = $dm->getRepository(Team::class)->findAll();



        $result = [];

        foreach ($teams as $team) {

            $result[] = [
                'id' => $team->getId(),
                'name' => $team->getName(),
                'code' => $team->getCode(),
                'description' => $team->getDescription(),
                'created_at' => $team->getCreatedAt(),
                'updated_at' => $team->getUpdatedAt(),
            ];
        }

        return CommonHelper::response(
            true,
            200,
            $result,
            "Teams retrieved successfully"
        );
    }

    public function workflowTemplates(DocumentManager $dm)
    {
        $templates = $dm->getRepository(WorkFlowTemplate::class)->findAll();
        // $templates = $dm->createQueryBuilder(WorkFlowTemplate::class)
        //                     ->getQuery()->toArray();

          $result = [];

        foreach ($templates as $template) {

            $result[] = [
                'id' => $template->getId(),
                'name' => $template->getName(),
                'code' => $template->getCode(),
                'description' => $template->getDescription(),
                'created_at' => $template->getCreatedAt(),
                'updated_at' => $template->getUpdatedAt(),
            ];
        }

        
        return CommonHelper::response(
            true,
            200,
            $result,
            "Templates retrived successfully"
        );
    }
}
