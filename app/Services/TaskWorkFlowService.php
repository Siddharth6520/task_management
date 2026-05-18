<?php

namespace App\Services;

use DateTime;
use App\Documents\Task;
use App\Documents\User;
use App\Documents\WorkFlowStages;
use App\Documents\WorkFlowTransition;
use Doctrine\ODM\MongoDB\DocumentManager;

class TaskWorkflowService
{
    public function transition(
        Task $task,
        string $transitionType,
        ?string $reason,
        ?string $comments,
        ?User $toAssignee,
        User $transitionedBy,
        DocumentManager $dm
    ): WorkFlowTransition {
        $currentStage = $task->getCurrentWorkflowStage();

        if (!$currentStage) {
            throw new \Exception("Current workflow stage not found");
        }

        $currentOrder = $currentStage->getStageOrder();

        $nextOrder = $transitionType === 'backward'
            ? $currentOrder - 1
            : $currentOrder + 1;

        $nextStage = $dm->getRepository(WorkFlowStages::class)->findOneBy([
            'workflow_template' => $task->getWorkflowTemplate(),
            'stage_order' => $nextOrder,
            'is_active' => true,
        ]);

        if (!$nextStage) {
            throw new \Exception("No next workflow stage found");
        }

        $oldDepartment = $task->getCurrentDepartment();
        $oldAssignee   = $task->getCurrentAssignee();

        $task->setCurrentWorkflowStage($nextStage);
        $task->setCurrentDepartment($nextStage->getDepartment());

        if ($toAssignee) {
            $task->setCurrentAssignee($toAssignee);
        }

        $transition = new WorkFlowTransition();
        $transition->setTask($task);
        $transition->setFromDepartment($oldDepartment);
        $transition->setToDepartment($nextStage->getDepartment());
        $transition->setFromAssignee($oldAssignee);
        $transition->setToAssignee($toAssignee ?? $oldAssignee);
        $transition->setFromWorkflowStage($currentStage);
        $transition->setToWorkflowStage($nextStage);
        $transition->setTransitionType($transitionType);
        $transition->setReason($reason);
        $transition->setComments($comments);
        $transition->setTransitionedBy($transitionedBy);
        $transition->setTransitionedAt(new DateTime());

        $dm->persist($transition);

        return $transition;
    }
}