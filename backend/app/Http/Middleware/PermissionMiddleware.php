<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Documents\RolePermission;

class PermissionMiddleware
{
    protected DocumentManager $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function handle(Request $request, Closure $next, string $permissionCode)
    {
        $user = $request->attributes->get('auth_user');

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthenticated'
            ], 401);
        }

        $role = $user->getRole();

        if (!$role) {
            return response()->json([
                'success' => false,
                'message' => 'No role assigned to user'
            ], 403);
        }

        // Super Admin bypass
        if ($role->getCode() === 'SUPER_ADMIN') {
            return $next($request);
        }

        // Check permissions
        $rolePermissions = $this->dm
            ->getRepository(RolePermission::class)
            ->findBy(['role' => $role]);

        foreach ($rolePermissions as $rp) {
            $permission = $rp->getPermission();

            if (
                $permission &&
                $permission->getIsActive() &&
                $permission->getCode() === strtoupper($permissionCode)
            ) {
                return $next($request);
            }
        }

        return response()->json([
            'success' => false,
            'message' => 'Forbidden: you do not have permission to perform this action'
        ], 403);
    }
}