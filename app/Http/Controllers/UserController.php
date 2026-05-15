<?php

namespace App\Http\Controllers;

use App\Documents\User;
use App\Helpers\CommonHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Doctrine\ODM\MongoDB\DocumentManager;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DocumentManager $dm)
    {
        $users = $dm->getRepository(User::class)->findAll();

        $result = [];
        foreach ($users as $user) {

            $result[] = [
                'id' => $user->getId(),
                'name' => $user->getName(),
                'email' => $user->getEmail(),
                'mobile_no' => $user->getMobileNo(),
                'username' => $user->getUsername(),
                'is_active' => $user->isActive(),
            ];
        }
        return CommonHelper::response(
            true,
            200,
            $result,
            "user data retrieved successfully"
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, DocumentManager $dm)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|min:6',
            'mobile_no' => 'required|regex:/^[0-9]{10}$/',
            'username' => 'required|string'
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

            // $exist = $dm->getRepository(User::class)->findOneBy(['email'=>$request->email, 'is_active'=> 'true']);

            $qb = $dm->createQueryBuilder(User::class);
            $qb->addOr($qb->expr()->field('email')->equals($request->email));
            $qb->addOr($qb->expr()->field('username')->equals($request->username));

            $exist = $qb->getQuery()->getSingleResult();

            if ($exist) {
                return CommonHelper::response(
                    false,
                    409,
                    null,
                    "User with email or username already exists"
                );
            }
            
            $user = new User();

            $user->setName($request->name);
            $user->setEmail($request->email);
            $user->setPassword($request->password);
            $user->setMobileNo($request->mobile_no);
            $user->setUsername($request->username);
            $user->setIsActive(true);

            $dm->persist($user);
            $dm->flush();

            return CommonHelper::response(
                true,
                201,
                null,
                "User created successfully"
            );
        } catch (\Exception $e) {
            CommonHelper::response(
                false,
                500,
                null,
                'Internal Server Error :- ' . $e->getMessage()
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, DocumentManager $dm)
    {
        $exist_user = $dm->getRepository(User::class)->find($id);

        if (!$exist_user) {
            return CommonHelper::response(
                false,
                404,
                null,
                "User not found"
            );
        }

        $user = [
            'id' => $exist_user->getId(),
            'name' => $exist_user->getName(),
            'email' => $exist_user->getEmail(),
            'mobile_no' => $exist_user->getMobileNo(),
            'username' => $exist_user->getUsername(),
            'is_active' => $exist_user->isActive()
        ];

        return CommonHelper::response(
            true,
            200,
            $user,
            "User Data retrieved successfully"
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, DocumentManager $dm)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string',
            'email' => 'sometimes|email',
            'mobile_no' => 'sometimes|regex:/^[0-9]{10}$/',
            'username' => 'sometimes|string'
        ]);

        if ($validator->fails()) {
            return CommonHelper::response(
                false,
                400,
                null,
                $validator->errors()->toArray()
            );
        }
        $user = $dm->getRepository(User::class)->find($id);

        if (!$user) {
            return CommonHelper::response(
                false,
                404,
                null,
                "User not found"
            );
        }

        try {
            if ($request->has('name')) {
                $user->setName($request->name);
            }

            if ($request->has('email')) {
                $user->setEmail($request->email);
            }

            if ($request->has('username')) {
                $user->setUsername($request->username);
            }

            if ($request->has('mobile_no')) {
                $user->setMobileNo($request->mobile_no);
            }

            if ($request->has('password')) {
                $user->setPassword($request->password);
            }

            $dm->flush();

            return CommonHelper::response(
                true,
                200,
                $user,
                "User updated successfully"
            );
        } catch (\Exception $e) {
            CommonHelper::response(
                false,
                500,
                null,
                "Internal Server Error :-" . $e->getMessage()
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, DocumentManager $dm)
    {
        try {
            $user = $dm->getRepository(User::class)->find($id);

            if (!$user) {
                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "User not found"
                );
            }

            $dm->remove($user);
            $dm->flush();
        } catch (\Exception $e) {
            return CommonHelper::response(
                false,
                500,
                null,
                "Internal Server Error :-" . $e->getMessage()
            );
        }
    }
}
