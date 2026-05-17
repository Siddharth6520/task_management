<?php

namespace App\Http\Controllers;

use DateTime;

use App\Documents\Team;
use App\Documents\User;
use App\Helpers\CommonHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Doctrine\ODM\MongoDB\DocumentManager;

class TeamsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DocumentManager $dm)
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, DocumentManager $dm)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
            'code' => 'required|string',
            'description' => 'nullable|string',
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

            $exist = $dm->getRepository(Team::class)
                ->findOneBy([
                    'code' => strtoupper($request->code)
                ]);

            if ($exist) {
                return CommonHelper::response(
                    false,
                    409,
                    null,
                    "Team code already exists"
                );
            }

            $team = new Team();

            $team->setName($request->name);
            $team->setCode($request->code);
            $team->setDescription($request->description);
            // $team->setCreatedAt(new DateTime());

            $dm->persist($team);
            $dm->flush();

            return CommonHelper::response(
                true,
                201,
                null,
                "Team created successfully"
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
        $team = $dm->getRepository(Team::class)->find($id);

        if (!$team) {
            return CommonHelper::response(
                false,
                404,
                null,
                "Team not found"
            );
        }

        $result = [
            'id' => $team->getId(),
            'name' => $team->getName(),
            'code' => $team->getCode(),
            'description' => $team->getDescription(),
            'created_at' => $team->getCreatedAt(),
            'updated_at' => $team->getUpdatedAt(),
        ];

        return CommonHelper::response(
            true,
            200,
            $result,
            "Team retrieved successfully"
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(
        Request $request,
        string $id,
        DocumentManager $dm
    ) {

        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string',
            'code' => 'sometimes|string',
            'description' => 'sometimes|nullable|string',
        ]);

        if ($validator->fails()) {
            return CommonHelper::response(
                false,
                400,
                null,
                $validator->errors()->toArray()
            );
        }

        $team = $dm->getRepository(Team::class)->find($id);

        if (!$team) {
            return CommonHelper::response(
                false,
                404,
                null,
                "Team not found"
            );
        }

        try {

            if ($request->has('code')) {

                $exist = $dm->createQueryBuilder(Team::class)
                    ->field('code')->equals(strtoupper($request->code))
                    ->field('id')->notEqual($id)
                    ->getQuery()
                    ->getSingleResult();

                if ($exist) {
                    return CommonHelper::response(
                        false,
                        409,
                        null,
                        "Team code already exists"
                    );
                }

                $team->setCode($request->code);
            }

            if ($request->has('name')) {
                $team->setName($request->name);
            }

            if ($request->exists('description')) {
                $team->setDescription($request->description);
            }

            // $team->setUpdatedAt(new DateTime());

            $dm->flush();

            return CommonHelper::response(
                true,
                200,
                null,
                "Team updated successfully"
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

            $team = $dm->getRepository(Team::class)->find($id);

            if (!$team) {
                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Team not found"
                );
            }

            $dm->remove($team);
            $dm->flush();

            return CommonHelper::response(
                true,
                200,
                null,
                "Team deleted successfully"
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