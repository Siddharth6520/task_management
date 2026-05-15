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

use Doctrine\ODM\MongoDB\DocumentManager;

class TasksController extends Controller
{

    public function index(DocumentManager $dm)
    {
        $tasks = $dm->getRepository(Tasks::class)->findAll();

        $result = [];

        foreach ($tasks as $task) {
            $result[] = [
                'id' => $task->getId(),
                'task_code' => $task->getTaskCode(),
                'title' => $task->getTitle(),
                'description' => $task->getDescription(),
                'project' => [
                    'id' => $task->getProject()->getId(),
                    'name' => $task->getProject()->getId()
                ],
                'department' => [
                    'id' => $task->getCurrentDepartment()->getId(),
                    'name' => $task->getCurrentDepartment()->getName()
                ],

                'assignee' => [
                    'id' => $task->getCurrentAssignee()->getId(),
                    'name' => $task->getCurrentAssignee()->getName()
                ],

                'workflow_template' => $task->getWorkflowTemplate()->getId(),
                'current_workflow_stage' => [
                    'id' => $task->getCurrentWorkflowStage()->getId(),
                    'name' => $task->getCurrentWorkflowStage()->getName()
                ],
                'execution_status' => $task->getExecutionStatus(),
                // 'created_at' => $task->getCreatedAt(),
                // 'updated_at' => $task->getUpdatedAt(),
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

            $task->setOriginalDueAt($request->original_due_at ? new \DateTime($request->original_due_at) : null);

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

        return CommonHelper::response(
            true,
            200,
            $task,
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

                $newStatus = $request->execution_status;

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
