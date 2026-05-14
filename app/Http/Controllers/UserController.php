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
        foreach($users as $user){

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
        $validator = Validator::make($request->all(),[
            'name'=> 'required|string',
            'email' => 'required|email',
            'mobile_no' => 'required|regex:/^[0-9]{10}$/',
            'username' => 'required|string'
        ]);

        if($validator->fails()){
            return CommonHelper::response(
                false,
                400,
                null,
                $validator->errors()->toArray()
            );
        }

        try{

            // $exist = $dm->getRepository(User::class)->findOneBy(['email'=>$request->email, 'is_active'=> 'true']);

            $qb = $dm->createQueryBuilder(User::class);
            $qb->addOr($qb->expr()->field('email')->equals($request->email));
            $qb->addOr($qb->expr()->field('username')->equals($request->username));

            $exist = $qb->getQuery()->getSingleResult();
                    
            $user = new User();

            $user->setName($request->name);
            $user->setEmail($request->email);
            $user->setPassword($request->password);
            $user->setMobileNo($request->mobile_no);
            $user->setUsername($request->username);
            $user->setIsActive('true');

            $dm->persist($user);
            $dm->flush();

            return CommonHelper::response(
                true,
                201,
                null,
                "User created successfully"
            );
        }
        catch(\Exception $e){

        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
