<?php

namespace App\Http\Controllers;

use App\Documents\Tasks;
use App\Documents\Department;
use App\Documents\Project;
use App\Documents\TaskStatusHistory;
use App\Documents\User;
use App\Documents\WorkTemplate;
use App\Documents\WorkStage;

use App\Http\Requests\TaskRequest;
use App\Http\Requests\UpdateTaskRequest;


use App\Helpers\CommonHelper;
// use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

use Doctrine\ODM\MongoDB\DocumentManager;

class TasksController extends Controller
{

    public function index(DocumentManager $dm)
    {
        $tasks = $dm->getRepository(Tasks::class)->findAll();

        $result = [];

        foreach ($tasks as $task) {

            $attachments = [];

            foreach ($task->getAttachments() as $attachment) {

                $attachments[] = [
                    'id' => $attachment->getId(),

                    'file_name' => $attachment->getFileName(),

                    'url' => Storage::url(
                        $attachment->getFilePath()
                    ),
                ];
            }

            $result[] = [

                'id' => $task->getId(),

                'task_code' => $task->getTaskCode(),

                'title' => $task->getTitle(),

                'description' => $task->getDescription(),

                'project' => $task->getProject()
                    ? [
                        'id' => $task->getProject()->getId(),
                        'name' => $task->getProject()->getName()
                    ]
                    : null,

                'department' => $task->getCurrentDepartment()
                    ? [
                        'id' => $task->getCurrentDepartment()->getId(),
                        'name' => $task->getCurrentDepartment()->getName()
                    ]
                    : null,

                'assignee' => $task->getCurrentAssignee()
                    ? [
                        'id' => $task->getCurrentAssignee()->getId(),
                        'name' => $task->getCurrentAssignee()->getName()
                    ]
                    : null,

                'workflow_template' => $task->getWorkflowTemplate()
                    ? [
                        'id' => $task->getWorkflowTemplate()->getId(),
                        'name' => $task->getWorkflowTemplate()->getName()
                    ]
                    : null,

                'current_workflow_stage' => $task->getCurrentWorkflowStage()
                    ? [
                        'id' => $task->getCurrentWorkflowStage()->getId(),
                        'name' => $task->getCurrentWorkflowStage()->getWorkflowTemplate()->getName() . " - " . $task->getCurrentWorkflowStage()->getStageName()
                    ]
                    : null,

                'execution_status' => $task->getExecutionStatus(),

                'priority' => $task->getPriority(),

                'is_sla_breached' => $task->isSlaBreached(),

                'sla_breach_count' => $task->getSlaBreachCount(),

                'started_at' => $task->getStartedAt()?->format('Y-m-d H:i:s'),

                'due_at' => $task->getDueAt()?->format('Y-m-d H:i:s'),

                'completed_at' => $task->getCompletedAt()?->format('Y-m-d H:i:s'),

                'attachments' => $attachments,

                'created_at' => $task->getCreatedAt()?->format('Y-m-d H:i:s'),

                'updated_at' => $task->getUpdatedAt()?->format('Y-m-d H:i:s'),
            ];
        }

        return CommonHelper::response(
            true,
            200,
            $result,
            "Tasks retrieved successfully"
        );
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskRequest $request, DocumentManager $dm)
    {

        $client = $dm->getClient();

        $session = $client->startSession();

        $session->startTransaction();

        try {

            $project = null;

            if ($request->filled('project_id')) {

                $project = $dm
                    ->getRepository(Project::class)
                    ->find($request->project_id);

                if (!$project) {

                    $session->abortTransaction();

                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        "Project not found"
                    );
                }
            }

            $department = $dm
                ->getRepository(Department::class)
                ->find($request->current_department_id);

            if (!$department) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Department not found"
                );
            }

            $assignee = $dm
                ->getRepository(User::class)
                ->find($request->current_assignee_id);

            if (!$assignee) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Assignee not found"
                );
            }

            $workflowTemplate = $dm
                ->getRepository(WorkTemplate::class)
                ->find($request->workflow_template_id);

            if (!$workflowTemplate) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Workflow template not found"
                );
            }

            $workflowStage = $dm
                ->getRepository(WorkStage::class)
                ->find($request->current_workflow_stage_id);

            if (!$workflowStage) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Workflow stage not found"
                );
            }

            $task = new Tasks();

            $task->setTaskCode($request->task_code);

            $task->setTitle($request->title);

            $task->setDescription($request->description);

            $task->setProject($project);

            $task->setCurrentDepartment($department);

            $task->setCurrentAssignee($assignee);

            $task->setWorkflowTemplate($workflowTemplate);

            $task->setCurrentWorkflowStage($workflowStage);

            $task->setExecutionStatus(
                $request->execution_status
            );

            $task->setPriority($request->priority);

            $task->setDueAt($request->due_at ? new \DateTime($request->due_at) : null);

            $task->setStartedAt($request->started_at ? new \DateTime($request->started_at) : null);
            $task->setCompletedAt($request->completed_at ? new \DateTime($request->completed_at) : null);

            // $task->setOriginalDueAt($request->original_due_at ? new \DateTime($request->original_due_at) : null);
            if (!$task->getOriginalDueAt() && $task->getDueAt()) {

                $task->setOriginalDueAt(
                    clone $task->getDueAt()
                );
            }
            // $task->setCreatedAt(new \DateTime());
            // $task->setUpdatedAt(new \DateTime());
            $task->setCreatedBy($assignee);
            $task->setUpdatedBy($assignee);
            $dm->persist($task);



            $statusHistory = new TaskStatusHistory();

            $statusHistory->setTask($task);

            $statusHistory->setFromStatus(null);

            $statusHistory->setToStatus(
                $task->getExecutionStatus()
            );

            $statusHistory->setChangedAt(new \DateTime());

            // $statusHistory->setCreatedAt(new \DateTime());

            $dm->persist($statusHistory);

            $dm->flush();
            $session->commitTransaction();

            return CommonHelper::response(
                true,
                201,
                [
                    'id' => $task->getId()
                ],
                "Task created successfully"
            );
        } catch (\Throwable $e) {

            $session->abortTransaction();

            $dm->clear();

            return CommonHelper::response(
                false,
                500,
                null,
                $e->getMessage()
            );
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, DocumentManager $dm)
    {
        $task = $dm->getRepository(Tasks::class)->find($id);

        if (!$task) {

            return CommonHelper::response(
                false,
                404,
                null,
                "No Task found"
            );
        }

        $attachments = [];

        foreach ($task->getAttachments() as $attachment) {

            $attachments[] = [
                'id' => $attachment->getId(),

                'file_name' => $attachment->getFileName(),

                'file_url' => Storage::url(
                    $attachment->getFilePath()
                ),

                'mime_type' => $attachment->getMimeType(),

                'workflow_stage' => $attachment->getWorkflowStage() ? [
                    'id' => $attachment->getWorkflowStage()->getId(),
                    'name' => $attachment->getWorkflowStage()->getName()
                ] : null,

                'uploaded_by' => $attachment->getUploadedBy() ? [
                    'id' => $attachment->getUploadedBy()->getId(),
                    'name' => $attachment->getUploadedBy()->getName()
                ] : null,

                'uploaded_at' => $attachment
                    ->getUploadedAt()
                    ?->format('Y-m-d H:i:s'),
            ];
        }

        $result = [
            'id' => $task->getId(),

            'task_code' => $task->getTaskCode(),

            'title' => $task->getTitle(),

            'description' => $task->getDescription(),

            'project' => $task->getProject() ? [
                'id' => $task->getProject()->getId(),
                'name' => $task->getProject()->getName()
            ] : null,

            'department' => $task->getCurrentDepartment() ? [
                'id' => $task->getCurrentDepartment()->getId(),
                'name' => $task->getCurrentDepartment()->getName()
            ] : null,

            'assignee' => $task->getCurrentAssignee() ? [
                'id' => $task->getCurrentAssignee()->getId(),
                'name' => $task->getCurrentAssignee()->getName()
            ] : null,

            'workflow_template' => $task->getWorkflowTemplate() ? [
                'id' => $task->getWorkflowTemplate()->getId(),
                'name' => $task->getWorkflowTemplate()->getName()
            ] : null,

            'current_workflow_stage' => $task->getCurrentWorkflowStage() ? [
                'id' => $task->getCurrentWorkflowStage()->getId(),
                'name' => $task->getCurrentWorkflowStage()->getWorkflowTemplate()->getName() . " - " . $task->getCurrentWorkflowStage()->getStageName() 
            ] : null,

            'execution_status' => $task->getExecutionStatus(),

            'priority' => $task->getPriority(),

            'started_at' => $task
                ->getStartedAt()
                ?->format('Y-m-d H:i:s'),

            'due_at' => $task
                ->getDueAt()
                ?->format('Y-m-d H:i:s'),

            'completed_at' => $task
                ->getCompletedAt()
                ?->format('Y-m-d H:i:s'),

            'original_due_at' => $task
                ->getOriginalDueAt()
                ?->format('Y-m-d H:i:s'),

            'is_sla_breached' => $task->isSlaBreached(),

            'sla_breach_count' => $task->getSlaBreachCount(),

            'attachments' => $attachments,

            'created_at' => $task
                ->getCreatedAt()
                ?->format('Y-m-d H:i:s'),

            'updated_at' => $task
                ->getUpdatedAt()
                ?->format('Y-m-d H:i:s'),
        ];

        return CommonHelper::response(
            true,
            200,
            $result,
            "Task retrieved successfully"
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateTaskRequest $request, string $id, DocumentManager $dm)
    {

        $client = $dm->getClient();

        $session = $client->startSession();

        $session->startTransaction();

        try {

            $task = $dm
                ->getRepository(Tasks::class)
                ->find($id);

            if (!$task) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Task not found"
                );
            }

            if ($request->filled('project_id')) {

                $project = $dm
                    ->getRepository(Project::class)
                    ->find($request->project_id);

                if (!$project) {

                    $session->abortTransaction();

                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        "Project not found"
                    );
                }

                $task->setProject($project);
            }

            if ($request->filled('current_department_id')) {

                $department = $dm
                    ->getRepository(Department::class)
                    ->find($request->current_department_id);

                if (!$department) {

                    $session->abortTransaction();

                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        "Department not found"
                    );
                }

                $task->setCurrentDepartment($department);
            }

            if ($request->filled('current_assignee_id')) {

                $assignee = $dm
                    ->getRepository(User::class)
                    ->find($request->current_assignee_id);

                if (!$assignee) {

                    $session->abortTransaction();

                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        "Assignee not found"
                    );
                }

                $task->setCurrentAssignee($assignee);

                $task->setUpdatedBy($assignee);
            }

            if ($request->filled('workflow_template_id')) {

                $workflowTemplate = $dm
                    ->getRepository(WorkTemplate::class)
                    ->find($request->workflow_template_id);

                if (!$workflowTemplate) {

                    $session->abortTransaction();

                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        "Workflow template not found"
                    );
                }

                $task->setWorkflowTemplate($workflowTemplate);
            }

            if ($request->filled('current_workflow_stage_id')) {

                $workflowStage = $dm
                    ->getRepository(WorkStage::class)
                    ->find($request->current_workflow_stage_id);

                if (!$workflowStage) {

                    $session->abortTransaction();

                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        "Workflow stage not found"
                    );
                }

                $task->setCurrentWorkflowStage($workflowStage);
            }


            if ($request->has('title')) {
                $task->setTitle($request->title);
            }

            if ($request->has('description')) {
                $task->setDescription($request->description);
            }

            if ($request->has('priority')) {
                $task->setPriority($request->priority);
            }


            if ($request->has('due_at')) {

                $task->setDueAt(
                    $request->due_at
                        ? new \DateTime($request->due_at)
                        : null
                );
            }

            if ($request->has('started_at')) {

                $task->setStartedAt(
                    $request->started_at
                        ? new \DateTime($request->started_at)
                        : null
                );
            }

            if ($request->has('completed_at')) {

                $task->setCompletedAt(
                    $request->completed_at
                        ? new \DateTime($request->completed_at)
                        : null
                );
            }

            /*
        |--------------------------------------------------------------------------
        | Status Change + Hold Tracking
        |--------------------------------------------------------------------------
        */

            if (
                $request->filled('execution_status')
                &&
                $task->getExecutionStatus() !== $request->execution_status
            ) {

                $oldStatus = $task->getExecutionStatus();

                //status completion blocked if SLA is breached
                $newStatus = $request->execution_status;
                if (
                    $newStatus === 'completed'
                    && $task->isSlaBreached()
                ) {
                    $session->abortTransaction();

                    return CommonHelper::response(
                        false,
                        422,
                        null,
                        "Task SLA is breached. Please request a due date extension before marking as completed."
                    );
                }

                // Calculate hold duration if moving to or from 'on_hold'
                $holdDuration = 0;


                if ($newStatus === 'on_hold') {

                    $task->setCurrentHoldStartedAt(
                        new \DateTime()
                    );
                }

                if (
                    $oldStatus === 'on_hold'
                    &&
                    $task->getCurrentHoldStartedAt()
                ) {

                    $holdStartedAt = $task
                        ->getCurrentHoldStartedAt();

                    $holdDuration =
                        time()
                        -
                        $holdStartedAt->getTimestamp();

                    $task->setTotalHoldDurationSeconds(
                        $task->getTotalHoldDurationSeconds()
                            + $holdDuration
                    );

                    $task->setCurrentHoldStartedAt(null);
                }

                $task->setExecutionStatus($newStatus);

                $statusHistory = new TaskStatusHistory();

                $statusHistory->setTask($task);

                $statusHistory->setFromStatus($oldStatus);

                $statusHistory->setToStatus($newStatus);

                $statusHistory->setHoldDurationSeconds(
                    $holdDuration
                );

                $statusHistory->setChangedBy(
                    $task->getCurrentAssignee()
                );

                $dm->persist($statusHistory);
            }

            $dm->flush();

            $session->commitTransaction();

            return CommonHelper::response(
                true,
                200,
                [
                    'id' => $task->getId()
                ],
                "Task updated successfully"
            );
        } catch (\Throwable $e) {

            $session->abortTransaction();

            $dm->clear();

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
    public function destroy(string $id, DocumentManager $dm)
    {

        $client = $dm->getClient();

        $session = $client->startSession();

        $session->startTransaction();

        try {

            $task = $dm
                ->getRepository(Tasks::class)
                ->find($id);

            if (!$task) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Task not found"
                );
            }

            $statusHistories = $dm
                ->getRepository(TaskStatusHistory::class)
                ->findBy([
                    'task.$id' => $task->getId()
                ]);

            foreach ($statusHistories as $history) {

                $dm->remove($history);
            }

            $dm->remove($task);

            $dm->flush();

            $session->commitTransaction();

            return CommonHelper::response(
                true,
                200,
                null,
                "Task deleted successfully"
            );
        } catch (\Throwable $e) {

            $session->abortTransaction();

            $dm->clear();

            return CommonHelper::response(
                false,
                500,
                null,
                $e->getMessage()
            );
        }
    }
}
