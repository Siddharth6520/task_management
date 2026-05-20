<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Doctrine\ODM\MongoDB\DocumentManager;
use Tymon\JWTAuth\Facades\JWTAuth;

class JwtMiddleware
{
    protected DocumentManager $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function handle(Request $request, Closure $next)
    {
        try {

            /*
            |--------------------------------------------------------------------------
            | Get Bearer Token
            |--------------------------------------------------------------------------
            */

            $token = JWTAuth::getToken();

            if (!$token) {

                return response()->json([
                    'success' => false,
                    'message' => 'Token missing'
                ], 401);
            }

            /*
            |--------------------------------------------------------------------------
            | Parse Payload ONLY
            |--------------------------------------------------------------------------
            */

            $payload = JWTAuth::setToken($token)->getPayload();

            /*
            |--------------------------------------------------------------------------
            | Get User ID From Token
            |--------------------------------------------------------------------------
            */

            $userId = $payload->get('sub');

            if (!$userId) {

                return response()->json([
                    'success' => false,
                    'message' => 'Invalid token'
                ], 401);
            }

            /*
            |--------------------------------------------------------------------------
            | Fetch User Manually Using Doctrine ODM
            |--------------------------------------------------------------------------
            */

            $user = $this->dm
                ->getRepository(\App\Documents\User::class)
                ->find($userId);

            if (!$user) {

                return response()->json([
                    'success' => false,
                    'message' => 'User not found'
                ], 401);
            }

            /*
            |--------------------------------------------------------------------------
            | Attach User To Request
            |--------------------------------------------------------------------------
            */

            $request->attributes->set('auth_user', $user);

            return $next($request);

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Unauthorized',
                'error' => $e->getMessage(),
                'line' => $e->getLine()
            ], 401);
        }
    }
}