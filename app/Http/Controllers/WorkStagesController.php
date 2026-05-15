<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Documents\WorkStage;
use App\Documents\Department;
use App\Documents\WorkFlowTemplate;
use App\Documents\Role;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Helpers\CommonHelper;
use Illuminate\Support\Facades\Validator;

class WorkStagesController extends Controller
{
    protected DocumentManager $dm;

    public function __construct(DocumentManager $dm)
    {
        $this->dm = $dm;
    }
    public function index()
    {
        //
        try {

            $stages = $this->dm
                ->getRepository(WorkStage::class)
                ->findAll();

            $data = [];

            foreach ($stages as $stage) {

                $data[] = [
                    'id' => $stage->getId(),
                    'workflow_template' => [
                        'id' => $stage->getWorkflowTemplate()?->getId(),
                        'name' => $stage->getWorkflowTemplate()?->getName(),
                    ],
                    'stage_name' => $stage->getStageName(),
                    'stage_order' => $stage->getStageOrder(),

                    'department' => [
                        'id' => $stage->getDepartment()?->getId(),
                        'name' => $stage->getDepartment()?->getName(),
                    ],

                    'role' => $stage->getRole()
                        ? [
                            'id' => $stage->getRole()?->getId(),
                            'name' => $stage->getRole()?->getName(),
                        ]
                        : null,

                    'can_skip' => $stage->canSkip(),
                    'can_rework' => $stage->canRework(),
                    'is_mandatory' => $stage->isMandatory(),
                    'is_final_stage' => $stage->isFinalStage(),
                    'sla_hours' => $stage->getSlaHours(),
                    'is_active' => $stage->isActive(),

                    'created_by' => $stage->getCreatedBy()?->getId(),
                    'updated_by' => $stage->getUpdatedBy()?->getId(),

                    'created_at' => $stage->getCreatedAt()?->format('Y-m-d H:i:s'),
                    'updated_at' => $stage->getUpdatedAt()?->format('Y-m-d H:i:s'),
                ];
            }

            return CommonHelper::response(
                true,
                200,
                $data,
                'Workflow stages fetched successfully'
            );

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch workflow stages',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {

            $validation = Validator::make($request->all(), [
                'workflow_template_id' => 'required|string',
                'stage_name' => 'required|string|max:255',
                'stage_order' => 'required|integer|min:1',
                'department_id' => 'required|string',
                'role_id' => 'nullable|string',

                'can_skip' => 'nullable|boolean',
                'can_rework' => 'nullable|boolean',
                'is_mandatory' => 'nullable|boolean',
                'is_final_stage' => 'nullable|boolean',
                'is_active' => 'nullable|boolean',

                'sla_hours' => 'nullable|numeric|min:0',
            ]);

            if ($validation->fails()) {

                return CommonHelper::response(
                    false,
                    422,
                    null,
                    $validation->errors()
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Fetch References
            |--------------------------------------------------------------------------
            */

            $workflowTemplate = $this->dm
                ->getRepository(WorkFlowTemplate::class)
                ->find($request->workflow_template_id);

            if (!$workflowTemplate) {

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    'Workflow template not found'
                );
            }

            $department = $this->dm
                ->getRepository(Department::class)
                ->find($request->department_id);

            if (!$department) {

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    'Department not found'
                );
            }

            $role = null;

            if ($request->filled('role_id')) {

                $role = $this->dm
                    ->getRepository(Role::class)
                    ->find($request->role_id);

                if (!$role) {

                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        'Role not found'
                    );
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Duplicate Stage Order Check
            |--------------------------------------------------------------------------
            */

            $existingStage = $this->dm
                ->getRepository(WorkStage::class)
                ->findOneBy([
                    'workflow_template' => $workflowTemplate,
                    'stage_order' => (int) $request->stage_order,
                ]);

            if ($existingStage) {

                return CommonHelper::response(
                    false,
                    409,
                    null,
                    'Stage order already exists for this workflow'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Create Stage
            |--------------------------------------------------------------------------
            */

            $stage = new WorkStage();

            $stage->setWorkflowTemplate($workflowTemplate);
            $stage->setStageName($request->stage_name);
            $stage->setStageOrder((int) $request->stage_order);
            $stage->setDepartment($department);
            $stage->setRole($role);

            $stage->setCanSkip(
                filter_var(
                    $request->can_skip ?? false,
                    FILTER_VALIDATE_BOOLEAN
                )
            );

            $stage->setCanRework(
                filter_var(
                    $request->can_rework ?? false,
                    FILTER_VALIDATE_BOOLEAN
                )
            );

            $stage->setIsMandatory(
                filter_var(
                    $request->is_mandatory ?? true,
                    FILTER_VALIDATE_BOOLEAN
                )
            );

            $stage->setIsFinalStage(
                filter_var(
                    $request->is_final_stage ?? false,
                    FILTER_VALIDATE_BOOLEAN
                )
            );

            $stage->setIsActive(
                filter_var(
                    $request->is_active ?? true,
                    FILTER_VALIDATE_BOOLEAN
                )
            );

            $stage->setSlaHours(
                $request->filled('sla_hours')
                    ? (float) $request->sla_hours
                    : null
            );

            $stage->setCreatedAt(new \DateTime());
            $stage->setUpdatedAt(new \DateTime());

            /*
            |--------------------------------------------------------------------------
            | Audit
            |--------------------------------------------------------------------------
            */

            // Uncomment after JWT/Auth setup

            // $user = auth()->user();

            // if ($user) {
            //     $stage->setCreatedBy($user);
            //     $stage->setUpdatedBy($user);
            // }

            /*
            |--------------------------------------------------------------------------
            | Save
            |--------------------------------------------------------------------------
            */

            $this->dm->persist($stage);
            $this->dm->flush();

            return CommonHelper::response(
                true,
                201,
                [
                    'id' => $stage->getId()
                ],
                'Workflow stage created successfully'
            );

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
                'line' => $e->getLine(),
            ], 500);
        }
    }

   /*
    |--------------------------------------------------------------------------
    | Show Single Stage
    |--------------------------------------------------------------------------
    */

    public function show(string $id)
    {
        try {

            $stage = $this->dm
                ->getRepository(WorkStage::class)
                ->find($id);

            if (!$stage) {

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    'Workflow stage not found'
                );
            }

            $data = [
                'id' => $stage->getId(),

                'workflow_template' => [
                    'id' => $stage->getWorkflowTemplate()?->getId(),
                    'name' => $stage->getWorkflowTemplate()?->getName(),
                ],

                'stage_name' => $stage->getStageName(),
                'stage_order' => $stage->getStageOrder(),

                'department' => [
                    'id' => $stage->getDepartment()?->getId(),
                    'name' => $stage->getDepartment()?->getName(),
                ],

                'role' => $stage->getRole()
                    ? [
                        'id' => $stage->getRole()?->getId(),
                        'name' => $stage->getRole()?->getName(),
                    ]
                    : null,

                'can_skip' => $stage->canSkip(),
                'can_rework' => $stage->canRework(),
                'is_mandatory' => $stage->isMandatory(),
                'is_final_stage' => $stage->isFinalStage(),
                'sla_hours' => $stage->getSlaHours(),
                'is_active' => $stage->isActive(),

                'created_at' => $stage->getCreatedAt()?->format('Y-m-d H:i:s'),
                'updated_at' => $stage->getUpdatedAt()?->format('Y-m-d H:i:s'),
            ];

            return CommonHelper::response(
                true,
                200,
                $data,
                'Workflow stage fetched successfully'
            );

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Update Workflow Stage
    |--------------------------------------------------------------------------
    */

    public function update(Request $request, string $id)
    {
        try {

            $stage = $this->dm
                ->getRepository(WorkStage::class)
                ->find($id);

            if (!$stage) {

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    'Workflow stage not found'
                );
            }

            if ($request->filled('stage_name')) {
                $stage->setStageName($request->stage_name);
            }

            if ($request->filled('stage_order')) {
                $stage->setStageOrder((int) $request->stage_order);
            }

            if ($request->has('can_skip')) {
                $stage->setCanSkip(
                    filter_var($request->can_skip, FILTER_VALIDATE_BOOLEAN)
                );
            }

            if ($request->has('can_rework')) {
                $stage->setCanRework(
                    filter_var($request->can_rework, FILTER_VALIDATE_BOOLEAN)
                );
            }

            if ($request->has('is_mandatory')) {
                $stage->setIsMandatory(
                    filter_var($request->is_mandatory, FILTER_VALIDATE_BOOLEAN)
                );
            }

            if ($request->has('is_final_stage')) {
                $stage->setIsFinalStage(
                    filter_var($request->is_final_stage, FILTER_VALIDATE_BOOLEAN)
                );
            }

            if ($request->has('is_active')) {
                $stage->setIsActive(
                    filter_var($request->is_active, FILTER_VALIDATE_BOOLEAN)
                );
            }

            if ($request->filled('sla_hours')) {
                $stage->setSlaHours((float) $request->sla_hours);
            }

            $stage->setUpdatedAt(new \DateTime());

            $this->dm->flush();

            return CommonHelper::response(
                true,
                200,
                null,
                'Workflow stage updated successfully'
            );

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Workflow Stage
    |--------------------------------------------------------------------------
    */

    public function destroy(string $id)
    {
        try {

            $stage = $this->dm
                ->getRepository(WorkStage::class)
                ->find($id);

            if (!$stage) {

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    'Workflow stage not found'
                );
            }

            $this->dm->remove($stage);
            $this->dm->flush();

            return CommonHelper::response(
                true,
                200,
                null,
                'Workflow stage deleted successfully'
            );

        } catch (\Throwable $e) {

            return response()->json([
                'success' => false,
                'message' => 'Internal Server Error',
                'error' => $e->getMessage(),
            ], 500);
        }
    }
}