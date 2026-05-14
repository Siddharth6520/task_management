<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Documents\User;
// use PHPOpenSourceSaver\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\CommonHelper;

class AuthController extends Controller
{
    protected $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        $user = $this->dm
            ->getRepository(User::class)
            ->findOneBy([
                'email' => $request->email
            ]);

        if (!$user) {
            return CommonHelper::response(
                false,
                404,
                null,
                'User not found'
            );
        }
        // dd($request->password, $user->getPassword());
        if (!password_verify($request->password, $user->getPassword())) {
            return CommonHelper::response(
                false,
                401,
                null,
                'Invalid password'
            );
        }

        $token = JWTAuth::fromUser($user);

        return CommonHelper::response(
            true,
            200,
            [
                'token' => $token,
                'user' => [
                    'id' => $user->getId(),
                    'name' => $user->getName(),
                    'email' => $user->getEmail()
                ]
            ],
            'Login successful'
        );
    }

    public function refresh()
    {
        try {

            $newToken = JWTAuth::parseToken()->refresh();

            return CommonHelper::response(
                true,
                200,
                [
                    'token' => $newToken
                ],
                'Token refreshed successfully'
            );

        } catch (\Exception $e) {

            return CommonHelper::response(
                false,
                401,
                null,
                'Token refresh failed'
            );
        }
    }

    public function logout()
    {
        try {

            JWTAuth::parseToken()->invalidate();

            return CommonHelper::response(
                true,
                200,
                null,
                'Logged out successfully'
            );

        } catch (\Exception $e) {
            echo $e->getMessage();
            return CommonHelper::response(
                false,
                401,
                null,
                'Unauthorized'
            );
        }
    }
    public function me()
    {
        try {

            $payload = JWTAuth::parseToken()->getPayload();

            $userId = $payload->get('sub');

            $user = $this->dm
                ->getRepository(User::class)
                ->find($userId);

            return CommonHelper::response(
                true,
                200,
                [
                    'user' => [
                        'id' => $user->getId(),
                        'name' => $user->getName(),
                        'email' => $user->getEmail(),
                    ]
                ],
                'User fetched successfully'
            );

        } catch (\Exception $e) {

            return CommonHelper::response(
                false,
                401,
                null,
                'Unauthorized'
            );
        }
    }
}


// namespace App\Http\Controllers\Api;

// use App\Http\Controllers\Controller;
// use Illuminate\Http\Request;

// class AuthController extends Controller
// {
//     //
// }
