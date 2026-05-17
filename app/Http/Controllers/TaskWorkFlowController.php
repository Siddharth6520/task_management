<?php

namespace App\Http\Controllers;

use App\Documents\Task;
use App\Documents\User;
use App\Documents\WorkFlowTransition;
use App\Helpers\CommonHelper;
use App\Services\TaskWorkflowService;
use Illuminate\Http\Request;
use Doctrine\ODM\MongoDB\DocumentManager;

class TaskWorkflowController extends Controller
{
    public function transition(
        Request $request,
        string $id,
        DocumentManager $dm,
        TaskWorkflowService $service
    ) {
        $validator = validator($request->all(), [
            'transition_type' => 'sometimes|in:forward,backward',
            'reason' => 'sometimes|nullable|string',
            'comments' => 'sometimes|nullable|string',
            'to_assignee_id' => 'sometimes|nullable|string',
        ]);

        if ($validator->fails()) {
            return CommonHelper::response(
                false,
                400,
                null,
                $validator->errors()->toArray()
            );
        }

        $client = $dm->getClient();
        $session = $client->startSession();
        $session->startTransaction();

        try {
            $task = $dm->getRepository(Task::class)->find($id);

            if (!$task) {
                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Task not found"
                );
            }

            $toAssignee = null;

            if ($request->filled('to_assignee_id')) {
                $toAssignee = $dm->getRepository(User::class)->find($request->to_assignee_id);

                if (!$toAssignee) {
                    $session->abortTransaction();

                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        "Assignee not found"
                    );
                }
            }

            $transitionedBy = $request->attributes->get('auth_user');

            if (!$transitionedBy) {
                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    401,
                    null,
                    "Unauthorized"
                );
            }

            $transition = $service->transition(
                $task,
                $request->transition_type ?? 'forward',
                $request->reason,
                $request->comments,
                $toAssignee,
                $transitionedBy,
                $dm
            );

            $dm->flush();
            $session->commitTransaction();

            return CommonHelper::response(
                true,
                200,
                [
                    'task_id' => $task->getId(),
                    'current_stage' => $task->getCurrentWorkflowStage() ? [
                        'id' => $task->getCurrentWorkflowStage()->getId(),
                        'name' => $task->getCurrentWorkflowStage()->getStageName(),
                        'order' => $task->getCurrentWorkflowStage()->getStageOrder(),
                    ] : null,
                    'current_department' => $task->getCurrentDepartment() ? [
                        'id' => $task->getCurrentDepartment()->getId(),
                        'name' => $task->getCurrentDepartment()->getName(),
                    ] : null,
                    'current_assignee' => $task->getCurrentAssignee() ? [
                        'id' => $task->getCurrentAssignee()->getId(),
                        'name' => $task->getCurrentAssignee()->getName(),
                    ] : null,
                    'recent_transition' => [
                        'id' => $transition->getId(),
                        'from_stage' => $transition->getFromWorkflowStage() ? [
                            'id' => $transition->getFromWorkflowStage()->getId(),
                            'name' => $transition->getFromWorkflowStage()->getStageName(),
                        ] : null,
                        'to_stage' => $transition->getToWorkflowStage() ? [
                            'id' => $transition->getToWorkflowStage()->getId(),
                            'name' => $transition->getToWorkflowStage()->getStageName(),
                        ] : null,
                        'from_department' => $transition->getFromDepartment() ? [
                            'id' => $transition->getFromDepartment()->getId(),
                            'name' => $transition->getFromDepartment()->getName(),
                        ] : null,
                        'to_department' => $transition->getToDepartment() ? [
                            'id' => $transition->getToDepartment()->getId(),
                            'name' => $transition->getToDepartment()->getName(),
                        ] : null,
                        'from_assignee' => $transition->getFromAssignee() ? [
                            'id' => $transition->getFromAssignee()->getId(),
                            'name' => $transition->getFromAssignee()->getName(),
                        ] : null,
                        'to_assignee' => $transition->getToAssignee() ? [
                            'id' => $transition->getToAssignee()->getId(),
                            'name' => $transition->getToAssignee()->getName(),
                        ] : null,
                        'transition_type' => $transition->getTransitionType(),
                        'reason' => $transition->getReason(),
                        'comments' => $transition->getComments(),
                        'transitioned_at' => $transition->getTransitionedAt()?->format('Y-m-d H:i:s'),
                    ],
                ],
                "Task moved successfully"
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

    public function workflow(string $id, DocumentManager $dm)
    {
        $task = $dm->getRepository(Task::class)->find($id);

        if (!$task) {
            return CommonHelper::response(
                false,
                404,
                null,
                "Task not found"
            );
        }

        $transitions = $dm->getRepository(WorkFlowTransition::class)->findBy(
            ['task' => $task],
            ['transitioned_at' => 'desc']
        );

        $history = [];

        foreach ($transitions as $transition) {
            $history[] = [
                'id' => $transition->getId(),
                'from_stage' => $transition->getFromWorkflowStage() ? [
                    'id' => $transition->getFromWorkflowStage()->getId(),
                    'name' => $transition->getFromWorkflowStage()->getStageName(),
                ] : null,
                'to_stage' => $transition->getToWorkflowStage() ? [
                    'id' => $transition->getToWorkflowStage()->getId(),
                    'name' => $transition->getToWorkflowStage()->getStageName(),
                ] : null,
                'from_department' => $transition->getFromDepartment() ? [
                    'id' => $transition->getFromDepartment()->getId(),
                    'name' => $transition->getFromDepartment()->getName(),
                ] : null,
                'to_department' => $transition->getToDepartment() ? [
                    'id' => $transition->getToDepartment()->getId(),
                    'name' => $transition->getToDepartment()->getName(),
                ] : null,
                'from_assignee' => $transition->getFromAssignee() ? [
                    'id' => $transition->getFromAssignee()->getId(),
                    'name' => $transition->getFromAssignee()->getName(),
                ] : null,
                'to_assignee' => $transition->getToAssignee() ? [
                    'id' => $transition->getToAssignee()->getId(),
                    'name' => $transition->getToAssignee()->getName(),
                ] : null,
                'transition_type' => $transition->getTransitionType(),
                'reason' => $transition->getReason(),
                'comments' => $transition->getComments(),
                'transitioned_at' => $transition->getTransitionedAt()?->format('Y-m-d H:i:s'),
            ];
        }

        $recent = $history[0] ?? null;

        return CommonHelper::response(
            true,
            200,
            [
                'task_id' => $task->getId(),
                'task_code' => $task->getTaskCode(),
                'current_stage' => $task->getCurrentWorkflowStage() ? [
                    'id' => $task->getCurrentWorkflowStage()->getId(),
                    'name' => $task->getCurrentWorkflowStage()->getStageName(),
                    'order' => $task->getCurrentWorkflowStage()->getStageOrder(),
                ] : null,
                'current_department' => $task->getCurrentDepartment() ? [
                    'id' => $task->getCurrentDepartment()->getId(),
                    'name' => $task->getCurrentDepartment()->getName(),
                ] : null,
                'current_assignee' => $task->getCurrentAssignee() ? [
                    'id' => $task->getCurrentAssignee()->getId(),
                    'name' => $task->getCurrentAssignee()->getName(),
                ] : null,
                'recent_transition' => $recent,
                'history' => $history,
                'available_actions' => $this->availableActions($task),
            ],
            "Workflow history retrieved successfully"
        );
    }

    private function availableActions(Task $task): array
    {
        $actions = ['transition'];

        $stage = $task->getCurrentWorkflowStage();

        if ($stage) {
            if ($stage->canSkip()) {
                $actions[] = 'skip';
            }

            if ($stage->canRework()) {
                $actions[] = 'rework';
            }

            if ($stage->isFinalStage()) {
                $actions[] = 'complete';
            }
        }

        return $actions;
    }
}