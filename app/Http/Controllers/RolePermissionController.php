<?php

namespace App\Http\Controllers;

use DateTime;

use App\Documents\Role;
use App\Documents\Permission;
use App\Documents\RolePermission;
use App\Documents\User;
use App\Helpers\CommonHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Doctrine\ODM\MongoDB\DocumentManager;


class RolePermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DocumentManager $dm)
    {
        $rolePermissions = $dm->getRepository(RolePermission::class)->findAll();

        $result = [];

        foreach ($rolePermissions as $rolePermission) {

            $result[] = [
                'id'         => $rolePermission->getId(),
                'role'       => $rolePermission->getRole() ? [
                    'id'   => $rolePermission->getRole()->getId(),
                    'name' => $rolePermission->getRole()->getName(),
                ] : null,
                'permission' => $rolePermission->getPermission() ? [
                    'id'   => $rolePermission->getPermission()->getId(),
                    'name' => $rolePermission->getPermission()->getName(),
                ] : null,
                'created_at' => $rolePermission->getCreatedAt(),
                'updated_at' => $rolePermission->getUpdatedAt(),
            ];
        }

        return CommonHelper::response(
            true,
            200,
            $result,
            "Role permissions retrieved successfully"
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, DocumentManager $dm)
    {
        $validator = Validator::make($request->all(), [
            'role_id' => 'required|string',
            'permission_ids' => 'required|array|min:1',
            'permission_ids.*' => 'required|string',
        ]);

        if ($validator->fails()) {
            return CommonHelper::response(
                false,
                400,
                null,
                $validator->errors()->toArray()
            );
        }

        try {

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

            $user = $dm->getRepository(User::class)
                ->find($request->user()->getAuthIdentifier());

            $created = [];
            $skipped = [];

            foreach ($request->permission_ids as $permissionId) {

                $permission = $dm->getRepository(Permission::class)
                    ->find($permissionId);

                if (!$permission) {

                    $skipped[] = [
                        'permission_id' => $permissionId,
                        'reason' => 'Permission not found'
                    ];

                    continue;
                }

                $exist = $dm->getRepository(RolePermission::class)
                    ->findOneBy([
                        'role' => $role,
                        'permission' => $permission
                    ]);

                if ($exist) {

                    $skipped[] = [
                        'permission_id' => $permissionId,
                        'reason' => 'Already exists'
                    ];

                    continue;
                }

                $rolePermission = new RolePermission();

                $rolePermission->setRole($role);
                $rolePermission->setPermission($permission);
                $rolePermission->setCreatedBy($user);

                $dm->persist($rolePermission);

                $created[] = [
                    'permission_id' => $permissionId,
                    'permission_name' => $permission->getName()
                ];
            }

            $dm->flush();

            return CommonHelper::response(
                true,
                201,
                [
                    'created' => $created,
                    'skipped' => $skipped,
                    'total_created' => count($created),
                    'total_skipped' => count($skipped)
                ],
                "Role permissions processed successfully"
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

    /**
     * Display the specified resource.
     */
    public function show(string $id, DocumentManager $dm)
    {
        $rolePermission = $dm->getRepository(RolePermission::class)->find($id);

        if (!$rolePermission) {
            return CommonHelper::response(
                false,
                404,
                null,
                "Role permission not found"
            );
        }

        $result = [
            'id'         => $rolePermission->getId(),
            'role'       => $rolePermission->getRole() ? [
                'id'   => $rolePermission->getRole()->getId(),
                'name' => $rolePermission->getRole()->getName(),
            ] : null,
            'permission' => $rolePermission->getPermission() ? [
                'id'   => $rolePermission->getPermission()->getId(),
                'name' => $rolePermission->getPermission()->getName(),
            ] : null,
            'created_by' => $rolePermission->getCreatedBy()?->getId(),
            'created_at' => $rolePermission->getCreatedAt(),
            'updated_by' => $rolePermission->getUpdatedBy()?->getId(),
            'updated_at' => $rolePermission->getUpdatedAt(),
        ];

        return CommonHelper::response(
            true,
            200,
            $result,
            "Role permission retrieved successfully"
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $roleId, DocumentManager $dm)
    {
        $validator = Validator::make($request->all(), [
            'permission_ids' => 'required|array|min:1',
            'permission_ids.*' => 'required|string'
        ]);

        if ($validator->fails()) {
            return CommonHelper::response(
                false,
                400,
                null,
                $validator->errors()->toArray()
            );
        }

        try {

            $role = $dm->getRepository(Role::class)
                ->find($roleId);

            if (!$role) {
                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Role not found"
                );
            }

            $user = $dm->getRepository(User::class)
                ->find($request->user()->getAuthIdentifier());

            $existingMappings = $dm->getRepository(RolePermission::class)
                ->findBy([
                    'role' => $role
                ]);

            $existingPermissionIds = [];

            foreach ($existingMappings as $mapping) {
                $existingPermissionIds[] =
                    $mapping->getPermission()->getId();
            }

            $newPermissionIds = $request->permission_ids;

            /*
        Delete removed permissions
        */

            foreach ($existingMappings as $mapping) {

                if (
                    !in_array(
                        $mapping->getPermission()->getId(),
                        $newPermissionIds
                    )
                ) {
                    $dm->remove($mapping);
                }
            }

            /*
        Add newly selected permissions
        */

            foreach ($newPermissionIds as $permissionId) {

                if (
                    in_array(
                        $permissionId,
                        $existingPermissionIds
                    )
                ) {
                    continue;
                }

                $permission = $dm->getRepository(Permission::class)
                    ->find($permissionId);

                if (!$permission) {
                    continue;
                }

                $rolePermission = new RolePermission();

                $rolePermission->setRole($role);
                $rolePermission->setPermission($permission);
                $rolePermission->setCreatedBy($user);

                $dm->persist($rolePermission);
            }

            $dm->flush();

            return CommonHelper::response(
                true,
                200,
                null,
                "Role permissions updated successfully"
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, DocumentManager $dm)
    {
        try {

            $rolePermission = $dm->getRepository(RolePermission::class)->find($id);

            if (!$rolePermission) {
                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Role permission not found"
                );
            }

            $dm->remove($rolePermission);
            $dm->flush();

            return CommonHelper::response(
                true,
                200,
                null,
                "Role permission deleted successfully"
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
