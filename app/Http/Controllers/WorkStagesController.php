<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Doctrine\ODM\MongoDB\DocumentManager;
use App\Documents\WorkFlowStages;
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
                ->getRepository(WorkFlowStages::class)
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

            /*
        |--------------------------------------------------------------------------
        | Validation
        |--------------------------------------------------------------------------
        */

            $validation = Validator::make(
                $request->all(),
                [
                    'workflow_template_id' => 'required|string',

                    'stages' => 'required|array|min:1',

                    'stages.*.stage_name' => 'required|string|max:255',

                    'stages.*.stage_order' =>
                    'required|integer|min:1',

                    'stages.*.department_id' =>
                    'required|string',

                    'stages.*.role_id' =>
                    'nullable|string',

                    'stages.*.can_skip' =>
                    'nullable|boolean',

                    'stages.*.can_rework' =>
                    'nullable|boolean',

                    'stages.*.is_mandatory' =>
                    'nullable|boolean',

                    'stages.*.is_final_stage' =>
                    'nullable|boolean',

                    'stages.*.is_active' =>
                    'nullable|boolean',

                    'stages.*.sla_hours' =>
                    'nullable|numeric|min:0',
                ]
            );

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
        | Workflow template check
        |--------------------------------------------------------------------------
        */

            $workflowTemplate = $this->dm
                ->getRepository(
                    WorkFlowTemplate::class
                )
                ->find(
                    $request->workflow_template_id
                );

            if (!$workflowTemplate) {

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    'Workflow template not found'
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Prevent duplicate orders inside request itself
        |--------------------------------------------------------------------------
        */

            $orders = array_column(
                $request->stages,
                'stage_order'
            );

            if (
                count($orders)
                != count(array_unique($orders))
            ) {

                return CommonHelper::response(
                    false,
                    400,
                    null,
                    'Duplicate stage order in request'
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Transaction
        |--------------------------------------------------------------------------
        */

            $session = $this->dm
                ->getClient()
                ->startSession();

            $session->startTransaction();

            foreach ($request->stages as $item) {

                /*
            |--------------------------------------------------------------------------
            | Department
            |--------------------------------------------------------------------------
            */

                $department = $this->dm
                    ->getRepository(
                        Department::class
                    )
                    ->find(
                        $item['department_id']
                    );

                if (!$department) {

                    throw new \Exception(
                        "Department not found : "
                            . $item['department_id']
                    );
                }

                /*
            |--------------------------------------------------------------------------
            | Existing stage order check
            |--------------------------------------------------------------------------
            */

                $exist = $this->dm
                    ->getRepository(
                        WorkFlowStages::class
                    )
                    ->findOneBy([
                        'workflow_template' =>
                        $workflowTemplate,

                        'stage_order' =>
                        (int)$item['stage_order']
                    ]);

                if ($exist) {

                    throw new \Exception(
                        'Stage order '
                            . $item['stage_order']
                            . ' already exists'
                    );
                }

                /*
            |--------------------------------------------------------------------------
            | Create Stage
            |--------------------------------------------------------------------------
            */

                $stage = new WorkFlowStages();

                $stage->setWorkflowTemplate(
                    $workflowTemplate
                );

                $stage->setStageName(
                    $item['stage_name']
                );

                $stage->setStageOrder(
                    (int)$item['stage_order']
                );

                $stage->setDepartment(
                    $department
                );

                $stage->setCanSkip(
                    $item['can_skip']
                        ?? false
                );

                $stage->setCanRework(
                    $item['can_rework']
                        ?? false
                );

                $stage->setIsMandatory(
                    $item['is_mandatory']
                        ?? true
                );

                $stage->setIsFinalStage(
                    $item['is_final_stage']
                        ?? false
                );

                $stage->setIsActive(
                    $item['is_active']
                        ?? true
                );

                $stage->setSlaHours(
                    $item['sla_hours']
                        ?? null
                );

                $stage->setCreatedAt(
                    new \DateTime()
                );

                $stage->setUpdatedAt(
                    new \DateTime()
                );

                $this->dm->persist(
                    $stage
                );
            }

            $this->dm->flush();

            $session->commitTransaction();

            return CommonHelper::response(
                true,
                201,
                null,
                'Workflow stages created successfully'
            );
        } catch (\Throwable $e) {

            if (isset($session)) {
                $session->abortTransaction();
            }

            return CommonHelper::response(
                false,
                500,
                null,
                $e->getMessage()
            );
        }
    }


    public function show(string $id)
    {
        try {

            $stage = $this->dm
                ->getRepository(WorkFlowStages::class)
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


    public function update(Request $request, string $id)
    {
        try {

            $validation = Validator::make(
                $request->all(),
                [
                    'stage_name' => 'sometimes|string|max:255',
                    'stage_order' => 'sometimes|integer|min:1',
                    'department_id' => 'sometimes|string',
                    'role_id' => 'nullable|string',

                    'can_skip' => 'sometimes|boolean',
                    'can_rework' => 'sometimes|boolean',
                    'is_mandatory' => 'sometimes|boolean',
                    'is_final_stage' => 'sometimes|boolean',
                    'is_active' => 'sometimes|boolean',

                    'sla_hours' => 'nullable|numeric|min:0',
                ]
            );

            if ($validation->fails()) {

                return CommonHelper::response(
                    false,
                    422,
                    null,
                    $validation->errors()
                );
            }

            $stage = $this->dm
                ->getRepository(
                    WorkFlowStages::class
                )
                ->find($id);

            if (!$stage) {

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    'Workflow stage not found'
                );
            }

            if ($request->filled('stage_order')) {

                $exist = $this->dm
                    ->createQueryBuilder(
                        WorkFlowStages::class
                    )
                    ->field('workflow_template')
                    ->references(
                        $stage->getWorkflowTemplate()
                    )
                    ->field('stage_order')
                    ->equals(
                        (int)$request->stage_order
                    )
                    ->field('id')
                    ->notEqual($id)
                    ->getQuery()
                    ->getSingleResult();

                if ($exist) {

                    return CommonHelper::response(
                        false,
                        409,
                        null,
                        'Stage order already exists'
                    );
                }

                $stage->setStageOrder(
                    (int)$request->stage_order
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Department update
        |--------------------------------------------------------------------------
        */

            if ($request->filled('department_id')) {

                $department = $this->dm
                    ->getRepository(
                        Department::class
                    )
                    ->find(
                        $request->department_id
                    );

                if (!$department) {

                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        'Department not found'
                    );
                }

                $stage->setDepartment(
                    $department
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Role update
        |--------------------------------------------------------------------------
        */

            if ($request->has('role_id')) {

                if ($request->filled('role_id')) {

                    $role = $this->dm
                        ->getRepository(
                            Role::class
                        )
                        ->find(
                            $request->role_id
                        );

                    if (!$role) {

                        return CommonHelper::response(
                            false,
                            404,
                            null,
                            'Role not found'
                        );
                    }

                    $stage->setRole($role);
                } else {

                    $stage->setRole(null);
                }
            }

            if ($request->filled('stage_name')) {
                $stage->setStageName(
                    $request->stage_name
                );
            }

            if ($request->has('can_skip')) {
                $stage->setCanSkip(
                    $request->boolean('can_skip')
                );
            }

            if ($request->has('can_rework')) {
                $stage->setCanRework(
                    $request->boolean('can_rework')
                );
            }

            if ($request->has('is_mandatory')) {
                $stage->setIsMandatory(
                    $request->boolean('is_mandatory')
                );
            }

            if ($request->has('is_final_stage')) {
                $stage->setIsFinalStage(
                    $request->boolean('is_final_stage')
                );
            }

            if ($request->has('is_active')) {
                $stage->setIsActive(
                    $request->boolean('is_active')
                );
            }

            if ($request->has('sla_hours')) {

                $stage->setSlaHours(
                    $request->filled('sla_hours')
                        ? (float)$request->sla_hours
                        : null
                );
            }

            $stage->setUpdatedAt(
                new \DateTime()
            );

            $this->dm->flush();

            return CommonHelper::response(
                true,
                200,
                null,
                'Workflow stage updated successfully'
            );
        } catch (\Throwable $e) {

            return CommonHelper::response(
                false,
                500,
                null,
                $e->getMessage()
            );
        }
    }

    public function destroy(string $id)
    {
        try {

            $stage = $this->dm
                ->getRepository(WorkFlowStages::class)
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
