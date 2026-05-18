<?php

namespace App\Http\Controllers;

use DateTime;

use App\Documents\Project;
use App\Documents\User;
use App\Helpers\CommonHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

use Doctrine\ODM\MongoDB\DocumentManager;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DocumentManager $dm)
    {
        $projects = $dm->getRepository(Project::class)->findAll();

        $result = [];

        foreach ($projects as $project) {

            $result[] = [
                'id'           => $project->getId(),
                'project_code' => $project->getProjectCode(),
                'name'         => $project->getName(),
                'description'  => $project->getDescription(),
                'is_active'    => $project->isActive(),
                'created_by'   => $project->getCreatedBy()?->getId(),
                'created_at'   => $project->getCreatedAt(),
                'updated_by'   => $project->getUpdatedBy()?->getId(),
                'updated_at'   => $project->getUpdatedAt(),
            ];
        }

        return CommonHelper::response(
            true,
            200,
            $result,
            "Projects retrieved successfully"
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, DocumentManager $dm)
    {
        $validator = Validator::make($request->all(), [
            'project_code' => 'required|string|max:50',
            'name'         => 'required|string|max:255',
            'description'  => 'nullable|string|max:1000',
            'is_active'    => 'nullable|boolean',
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

            $exist = $dm->getRepository(Project::class)
                ->findOneBy([
                    'project_code' => strtoupper(trim($request->project_code))
                ]);

            if ($exist) {
                return CommonHelper::response(
                    false,
                    409,
                    null,
                    "Project code already exists"
                );
            }

            $user = $request->attributes->get('auth_user');
            $project = new Project();

            $project->setProjectCode($request->project_code);
            $project->setName($request->name);

            if ($request->exists('description')) {
                $project->setDescription($request->description);
            }

            $project->setIsActive($request->input('is_active', true));
            $project->setCreatedBy($user);
            // $project->setCreatedAt(new DateTime());

            $dm->persist($project);
            $dm->flush();

            return CommonHelper::response(
                true,
                201,
                null,
                "Project created successfully"
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
        $project = $dm->getRepository(Project::class)->find($id);

        if (!$project) {
            return CommonHelper::response(
                false,
                404,
                null,
                "Project not found"
            );
        }

        $result = [
            'id'           => $project->getId(),
            'project_code' => $project->getProjectCode(),
            'name'         => $project->getName(),
            'description'  => $project->getDescription(),
            'is_active'    => $project->isActive(),
            'created_by'   => $project->getCreatedBy()?->getId(),
            'created_at'   => $project->getCreatedAt(),
            'updated_by'   => $project->getUpdatedBy()?->getId(),
            'updated_at'   => $project->getUpdatedAt(),
        ];

        return CommonHelper::response(
            true,
            200,
            $result,
            "Project retrieved successfully"
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id, DocumentManager $dm)
    {
        $validator = Validator::make($request->all(), [
            'project_code' => 'sometimes|string|max:50',
            'name'         => 'sometimes|string|max:255',
            'description'  => 'sometimes|nullable|string|max:1000',
            'is_active'    => 'sometimes|boolean',
        ]);

        if ($validator->fails()) {
            return CommonHelper::response(
                false,
                400,
                null,
                $validator->errors()->toArray()
            );
        }

        $project = $dm->getRepository(Project::class)->find($id);

        if (!$project) {
            return CommonHelper::response(
                false,
                404,
                null,
                "Project not found"
            );
        }

        try {

            if ($request->has('project_code')) {

                $exist = $dm->createQueryBuilder(Project::class)
                    ->field('project_code')->equals(strtoupper(trim($request->project_code)))
                    ->field('id')->notEqual($id)
                    ->getQuery()
                    ->getSingleResult();

                if ($exist) {
                    return CommonHelper::response(
                        false,
                        409,
                        null,
                        "Project code already exists"
                    );
                }

                $project->setProjectCode($request->project_code);
            }

            if ($request->has('name')) {
                $project->setName($request->name);
            }

            if ($request->exists('description')) {
                $project->setDescription($request->description);
            }

            if ($request->has('is_active')) {
                $project->setIsActive($request->boolean('is_active'));
            }

            $user = $request->attributes->get('auth_user');
            $project->setUpdatedBy($user);
            // $project->setUpdatedAt(new DateTime());

            $dm->flush();

            return CommonHelper::response(
                true,
                200,
                null,
                "Project updated successfully"
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

            $project = $dm->getRepository(Project::class)->find($id);

            if (!$project) {
                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Project not found"
                );
            }

            $dm->remove($project);
            $dm->flush();

            return CommonHelper::response(
                true,
                200,
                null,
                "Project deleted successfully"
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
