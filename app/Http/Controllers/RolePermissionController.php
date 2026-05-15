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
            'role_id'       => 'required|string',
            'permission_id' => 'required|string',
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

            $role = $dm->getRepository(Role::class)->find($request->role_id);

            if (!$role) {
                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Role not found"
                );
            }

            $permission = $dm->getRepository(Permission::class)->find($request->permission_id);

            if (!$permission) {
                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Permission not found"
                );
            }

            $exist = $dm->getRepository(RolePermission::class)
                ->findOneBy([
                    'role'       => $role->getId(),
                    'permission' => $permission->getId(),
                ]);

            if ($exist) {
                return CommonHelper::response(
                    false,
                    409,
                    null,
                    "Role permission already exists"
                );
            }

            $user = $dm->getRepository(User::class)->find($request->user()->getAuthIdentifier());
            $rolePermission = new RolePermission();

            $rolePermission->setRole($role);
            $rolePermission->setPermission($permission);
            $rolePermission->setCreatedBy($user);
            $rolePermission->setCreatedAt(new DateTime());

            $dm->persist($rolePermission);
            $dm->flush();

            return CommonHelper::response(
                true,
                201,
                null,
                "Role permission created successfully"
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
    public function update(Request $request, string $id, DocumentManager $dm)
    {
        $validator = Validator::make($request->all(), [
            'role_id'       => 'sometimes|string',
            'permission_id' => 'sometimes|string',
        ]);

        if ($validator->fails()) {
            return CommonHelper::response(
                false,
                400,
                null,
                $validator->errors()->toArray()
            );
        }

        $rolePermission = $dm->getRepository(RolePermission::class)->find($id);

        if (!$rolePermission) {
            return CommonHelper::response(
                false,
                404,
                null,
                "Role permission not found"
            );
        }

        try {

            if ($request->has('role_id')) {

                $role = $dm->getRepository(Role::class)->find($request->role_id);

                if (!$role) {
                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        "Role not found"
                    );
                }

                $rolePermission->setRole($role);
            }

            if ($request->has('permission_id')) {

                $permission = $dm->getRepository(Permission::class)->find($request->permission_id);

                if (!$permission) {
                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        "Permission not found"
                    );
                }

                $rolePermission->setPermission($permission);
            }

            $exist = $dm->createQueryBuilder(RolePermission::class)
                ->field('role')->equals($rolePermission->getRole()->getId())
                ->field('permission')->equals($rolePermission->getPermission()->getId())
                ->field('id')->notEqual($id)
                ->getQuery()
                ->getSingleResult();

            if ($exist) {
                return CommonHelper::response(
                    false,
                    409,
                    null,
                    "Role permission already exists"
                );
            }

            $user = $dm->getRepository(User::class)->find($request->user()->getAuthIdentifier());

            $rolePermission->setUpdatedBy($user);
            $rolePermission->setUpdatedAt(new DateTime());

            $dm->flush();

            return CommonHelper::response(
                true,
                200,
                null,
                "Role permission updated successfully"
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
