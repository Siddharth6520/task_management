<?php

namespace App\Http\Controllers;

use App\Documents\Department;
use App\Documents\Role;
use App\Documents\Team;
use App\Helpers\CommonHelper;
use App\Documents\TeamMember;
use App\Documents\User;



use Doctrine\ODM\MongoDB\DocumentManager;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use App\Imports\TeamMembersImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\BulkTeamMemberRequest;

class TeamMemberController extends Controller
{
    //all team member
    public function index(DocumentManager $dm)
    {
        $team_members = $dm->getRepository(TeamMember::class)->findAll();

        $result = [];

        foreach ($team_members as $team_member) {
            $result[] = [
                'id' => $team_member->getId(),
                'team' => [
                    'id' => $team_member->getTeam()->getId(),
                    'name' => $team_member->getTeam()->getName(),
                    'code' => $team_member->getTeam()->getCode()
                ],
                'employee' => $team_member->getUser()
                    ? [
                        'id' => $team_member->getUser()->getId(),
                        'name' => $team_member->getUser()->getName(),
                        'email' => $team_member->getUser()->getEmail(),
                        'username' => $team_member->getUser()->getUsername(),
                        'mobile_no' => $team_member->getUser()->getMobileNo(),
                    ]
                    : null,

                'department' => $team_member->getDepartment()
                    ? [
                        'id' => $team_member->getDepartment()->getId(),
                        'name' => $team_member->getDepartment()->getName(),
                    ]
                    : null,

                'role' => $team_member->getRole()
                    ? [
                        'id' => $team_member->getRole()->getId(),
                        'name' => $team_member->getRole()->getName(),
                    ]
                    : null,

                'reporting_manager' => $team_member->getReportingManager()
                    ? [
                        'id' => $team_member->getReportingManager()->getId(),
                        'name' => $team_member->getReportingManager()->getName(),
                        'email' => $team_member->getReportingManager()->getEmail(),
                    ]
                    : null,

                'is_active' => $team_member->isActive(),

                'created_at' => $team_member->getCreatedAt(),

                'updated_at' => $team_member->getUpdatedAt(),

                'created_by' => $team_member->getCreatedBy()
                    ? [
                        'id' => $team_member->getCreatedBy()->getId(),
                        'name' => $team_member->getCreatedBy()->getName(),
                    ]
                    : null,

                'updated_by' => $team_member->getUpdatedBy()
                    ? [
                        'id' => $team_member->getUpdatedBy()->getId(),
                        'name' => $team_member->getUpdatedBy()->getName(),
                    ]
                    : null,
            ];
        }

        return CommonHelper::response(
            true,
            200,
            $result,
            "employee data retrieved successfully"
        );
    }

    //create
    public function store(Request $request, DocumentManager $dm)
    {
        $validator = Validator::make($request->all(), [
            'team_id' => 'required|numeric',
            'user_id' => 'required|numeric',
            'department_id' => 'required|numeric',
            'role_id' => 'required|numeric',
            'reporting_manager_id' => 'required|numeric'
        ]);

        if ($validator->fails()) {
            return CommonHelper::response(
                false,
                400,
                null,
                $validator->errors()->toArray()
            );
        }

        $team = $dm->getRepository(Team::class)
            ->find($request->team_id);

        if (!$team) {
            return CommonHelper::response(
                false,
                404,
                null,
                "Team not found"
            );
        }

        $user = $dm->getRepository(User::class)
            ->find($request->user_id);

        if (!$user) {
            return CommonHelper::response(
                false,
                404,
                null,
                "User not found"
            );
        }

        $department = $dm->getRepository(Department::class)
            ->find($request->department_id);

        if (!$department) {
            return CommonHelper::response(
                false,
                404,
                null,
                "Department not found"
            );
        }

        $role = $dm->getRepository(Role::class)
            ->find($request->role_id);

        if (!$role) {
            return CommonHelper::response(
                false,
                404,
                null,
                "Role not found"
            );
        }

        $reporting_manager = null;

        if ($request->filled('reporting_manager_id')) {

            $reporting_manager = $dm->getRepository(User::class)
                ->find($request->reporting_manager_id);

            if (!$reporting_manager) {
                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Reporting manager not found"
                );
            }
        }

        try {

            $exist = $dm->getRepository(TeamMember::class)
                ->findOneBy([
                    'team' => $team,
                    'user' => $user,
                    'department' => $department
                ]);

            if ($exist) {
                return CommonHelper::response(
                    false,
                    409,
                    null,
                    "Employee already exists in this team and department"
                );
            }

            $team_member = new TeamMember();

            $team_member->setTeam($team);

            $team_member->setUser($user);

            $team_member->setDepartment($department);

            $team_member->setRole($role);

            $team_member->setReportingManager($reporting_manager);

            $team_member->setIsActive(
                $request->has('is_active')
                    ? $request->is_active
                    : true
            );

            $team_member->setCreatedAt(new \DateTime());

            $dm->persist($team_member);

            $dm->flush();

            return CommonHelper::response(
                true,
                201,
                null,
                "Employee assigned successfully"
            );
        } catch (\Exception $e) {
            return CommonHelper::response(
                false,
                500,
                null,
                "Internal Server Error :-" . $e->getMessage()
            );
        }
    }

     //bulk_create
    public function bulk_store(BulkTeamMemberRequest $request, DocumentManager $dm) {

        try {

            Excel::import(
                new TeamMembersImport($dm),
                $request->file('file')
            );

            return CommonHelper::response(
                true,
                201,
                null,
                "Bulk employee import completed successfully"
            );
        } catch (\Exception $e) {

            return CommonHelper::response(
                false,
                500,
                null,
                "Internal Server Error :- " . $e->getMessage()
            );
        }
    }

    //read
    public function show(string $id, DocumentManager $dm)
    {
        $team_member = $dm->getRepository(TeamMember::class)->find($id);

        if (!$team_member) {
            return CommonHelper::response(
                false,
                404,
                null,
                "Employee data not found"
            );
        }

        $result = [

            'id' => $team_member->getId(),

            'team' => [
                'id' => $team_member->getTeam()->getId(),
                'name' => $team_member->getTeam()->getName(),
                'code' => $team_member->getTeam()->getCode()
            ],

            'employee' => $team_member->getUser()
                ? [
                    'id' => $team_member->getUser()->getId(),
                    'name' => $team_member->getUser()->getName(),
                    'email' => $team_member->getUser()->getEmail(),
                    'username' => $team_member->getUser()->getUsername(),
                    'mobile_no' => $team_member->getUser()->getMobileNo(),
                ]
                : null,

            'department' => $team_member->getDepartment()
                ? [
                    'id' => $team_member->getDepartment()->getId(),
                    'name' => $team_member->getDepartment()->getName(),
                ]
                : null,

            'role' => $team_member->getRole()
                ? [
                    'id' => $team_member->getRole()->getId(),
                    'name' => $team_member->getRole()->getName(),
                ]
                : null,

            'reporting_manager' => $team_member->getReportingManager()
                ? [
                    'id' => $team_member->getReportingManager()->getId(),
                    'name' => $team_member->getReportingManager()->getName(),
                    'email' => $team_member->getReportingManager()->getEmail(),
                ]
                : null,

            'is_active' => $team_member->isActive(),

            'created_at' => $team_member->getCreatedAt(),

            'updated_at' => $team_member->getUpdatedAt(),

            'created_by' => $team_member->getCreatedBy()
                ? [
                    'id' => $team_member->getCreatedBy()->getId(),
                    'name' => $team_member->getCreatedBy()->getName(),
                ]
                : null,

            'updated_by' => $team_member->getUpdatedBy()
                ? [
                    'id' => $team_member->getUpdatedBy()->getId(),
                    'name' => $team_member->getUpdatedBy()->getName(),
                ]
                : null,
        ];

        return CommonHelper::response(
            true,
            200,
            $result,
            "Employee data retrieved successfully"
        );
    }

    //update
    public function update(Request $request, string $id, DocumentManager $dm)
    {

        $validator = Validator::make($request->all(), [
            'team_id' => 'sometimes|string',
            'user_id' => 'sometimes|string',
            'department_id' => 'sometimes|string',
            'role_id' => 'sometimes|string',
            'reporting_manager_id' => 'nullable|string',
            'is_active' => 'sometimes|boolean'
        ]);

        if ($validator->fails()) {
            return CommonHelper::response(
                false,
                400,
                null,
                $validator->errors()->toArray()
            );
        }

        $team_member = $dm->getRepository(TeamMember::class)
            ->find($id);

        if (!$team_member) {
            return CommonHelper::response(
                false,
                404,
                null,
                "Employee assignment not found"
            );
        }

        try {

            $team = $team_member->getTeam();

            if ($request->has('team_id')) {

                $team = $dm->getRepository(Team::class)
                    ->find($request->team_id);

                if (!$team) {
                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        "Team not found"
                    );
                }

                $team_member->setTeam($team);
            }

            $user = $team_member->getUser();

            if ($request->has('user_id')) {

                $user = $dm->getRepository(User::class)
                    ->find($request->user_id);

                if (!$user) {
                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        "User not found"
                    );
                }

                $team_member->setUser($user);
            }

            $department = $team_member->getDepartment();

            if ($request->has('department_id')) {

                $department = $dm->getRepository(Department::class)
                    ->find($request->department_id);

                if (!$department) {
                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        "Department not found"
                    );
                }

                $team_member->setDepartment($department);
            }

            if ($request->has('role_id')) {

                $role = $dm->getRepository(Role::class)
                    ->find($request->role_id);

                if (!$role) {
                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        "Role not found"
                    );
                }

                $team_member->setRole($role);
            }

            if ($request->has('reporting_manager_id')) {

                if ($request->filled('reporting_manager_id')) {

                    $reporting_manager = $dm->getRepository(User::class)
                        ->find($request->reporting_manager_id);

                    if (!$reporting_manager) {
                        return CommonHelper::response(
                            false,
                            404,
                            null,
                            "Reporting manager not found"
                        );
                    }

                    if (
                        $user &&
                        $reporting_manager->getId() === $user->getId()
                    ) {
                        return CommonHelper::response(
                            false,
                            400,
                            null,
                            "Employee cannot report to themselves"
                        );
                    }

                    $team_member->setReportingManager(
                        $reporting_manager
                    );
                } else {

                    $team_member->setReportingManager(null);
                }
            }

            if ($request->has('is_active')) {

                $team_member->setIsActive(
                    $request->is_active
                );
            }

            $exist = $dm->createQueryBuilder(TeamMember::class)
                ->field('team')->references($team)
                ->field('user')->references($user)
                ->field('department')->references($department)
                ->field('id')->notEqual($id)
                ->getQuery()
                ->getSingleResult();

            if ($exist) {
                return CommonHelper::response(
                    false,
                    409,
                    null,
                    "Employee already exists in this team and department"
                );
            }

            $team_member->setUpdatedAt(new \DateTime());

            $dm->flush();

            return CommonHelper::response(
                true,
                200,
                null,
                "Employee assignment updated successfully"
            );
        } catch (\Exception $e) {

            return CommonHelper::response(
                false,
                500,
                null,
                "Internal Server Error :- " . $e->getMessage()
            );
        }
    }

    //delete
    public function destroy(string $id, DocumentManager $dm)
    {
        try {

            $team_member = $dm->getRepository(TeamMember::class)
                ->find($id);

            if (!$team_member) {
                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Employee not found"
                );
            }

            $dm->remove($team_member);

            $dm->flush();

            return CommonHelper::response(
                true,
                200,
                null,
                "Employee deleted successfully"
            );
        } catch (\Exception $e) {

            return CommonHelper::response(
                false,
                500,
                null,
                "Internal Server Error :- " . $e->getMessage()
            );
        }
    }

   
}
