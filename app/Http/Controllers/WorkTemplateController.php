<?php

namespace App\Http\Controllers;

// use App\Models\WorkTemplate;
use Illuminate\Http\Request;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Documents\WorkFlowTemplate;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\CommonHelper;;

use Illuminate\Support\Facades\Validator;

class WorkTemplateController extends Controller
{
    protected $dm;
    /**
     * Display a listing of the resource.
     */

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }


    public function index()
    {
        //
        try { 
            $workTemplates = $this->dm->getRepository(WorkFlowTemplate::class)->findAll();
            $data = array_map(
                fn($item) => $item->toArray(),
                $workTemplates
            );
            return CommonHelper::response(
                true,
                200,
                $data,
                'Work templates retrieved successfully'
            );
        } catch (\Exception $e) {
            return CommonHelper::response(
                false,
                500,
                null,
                $e->getMessage()
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validation =  Validator::make($request->all(), [
                'name' => 'required|string',
                'code' => 'required|string',
                'description' => 'nullable|string',
                'is_active' => 'nullable|boolean',
                'is_default' => 'nullable|boolean',
            ]);

            if ($validation->fails()) {
                return CommonHelper::response(
                    false,
                    422,
                    null,
                    $validation->errors()
                );
            }
            $existing = $this->dm
                ->getRepository(WorkFlowTemplate::class)
                ->findOneBy([
                    'code' => strtoupper(trim($request->code)),
                ]);

            if ($existing) {
                return CommonHelper::response(
                    false,
                    409,
                    null,
                    'Workflow code already exists'
                );
            }

            $workTemplate = new WorkFlowTemplate();
            $workTemplate->setName($request->name);
            $workTemplate->setCode($request->code);
            $workTemplate->setDescription($request->description);
            // $workTemplate->setIsActive(filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN));
            // $workTemplate->setIsDefault(filter_var($request->is_default, FILTER_VALIDATE_BOOLEAN));
            $workTemplate->setCreatedAt(new \DateTime());
            $workTemplate->setUpdatedAt(new \DateTime());
            // $payload = JWTAuth::parseToken()->getPayload();

            // dd($workTemplate); 
            $this->dm->persist($workTemplate);
            $this->dm->flush();

            return CommonHelper::response(
                true,
                201,
                $workTemplate,
                'Work template created successfully'
            );
        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'actual_error' => $e->getMessage(),
                'line' => $e->getLine(),
                'file' => $e->getFile(),
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, WorkFlowTemplate $workTemplate, Request $request)
    {
        //
        try {
            $workTemplate = $this->dm->getRepository(WorkFlowTemplate::class)->find($id);
            return CommonHelper::response(
                true,
                200,
                $workTemplate->toArray(),
                'Work template retrieved successfully'
            );
        } catch (\Exception $e) {
            return CommonHelper::response(
                false,
                404,
                null,
                'Work template not found'
            );
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(string $id, Request $request)
    {
        try {

            $request->validate([
                'name' => 'required|string',
                'code' => 'required|string',
            ]);

            $workTemplate = $this->dm
                ->getRepository(WorkFlowTemplate::class)
                ->find($id);

            // Check if document exists
            if (!$workTemplate) {

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    'Work template not found'
                );
            }

            $workTemplate->setName($request->name);
            $workTemplate->setCode($request->code);

            // Optional fields
            if ($request->has('description')) {
                $workTemplate->setDescription($request->description);
            }

            // Audit update
            $workTemplate->setUpdatedAt(new \DateTime());

            // if using auth
            // $workTemplate->setUpdatedBy(auth()->user()->id);

            $this->dm->flush();

            return CommonHelper::response(
                true,
                200,
                $workTemplate->toArray(),
                'Work template updated successfully'
            );
        } catch (\Exception $e) {

            return CommonHelper::response(
                false,
                500,
                null,
                $e->getMessage()
            );
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, Request $request)
    {
        //
        try {
            $workTemplate = $this->dm->getRepository(WorkFlowTemplate::class)->find($id);
            $this->dm->remove($workTemplate);
            $this->dm->flush();

            return CommonHelper::response(
                true,
                200,
                null,
                'Work template deleted successfully'
            );
        } catch (\Exception $e) {
            return CommonHelper::response(
                false,
                500,
                null,
                'Failed to delete work template'
            );
        }
    }
}
