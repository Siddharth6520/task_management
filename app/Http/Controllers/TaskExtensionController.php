<?php

namespace App\Http\Controllers;

use DateTime;

use App\Documents\User;
use App\Documents\Task;
use App\Documents\TaskExtension;

use App\Helpers\CommonHelper;

use Illuminate\Http\Request;

use MongoDB\BSON\ObjectId;

use Doctrine\ODM\MongoDB\DocumentManager;

class TaskExtensionController extends Controller
{
    //request extension
    public function store(
        Request $request,
        string $taskId,
        DocumentManager $dm
    ) {

        $request->validate([
            'reason' => 'required|string|min:10|max:1000'
        ]);

        $client = $dm->getClient();

        $session = $client->startSession();

        $session->startTransaction();

        try {

            $task = $dm
                ->getRepository(Task::class)
                ->find($taskId);

            if (!$task) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Task not found"
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Allow only breached tasks
            |--------------------------------------------------------------------------
            */

            if (!$task->isSlaBreached()) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    422,
                    null,
                    "Task SLA is not breached"
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Block completed/closed/cancelled tasks
            |--------------------------------------------------------------------------
            */

            if (
                in_array(
                    $task->getExecutionStatus(),
                    ['completed', 'closed', 'cancelled']
                )
            ) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    422,
                    null,
                    "Extension cannot be requested for closed task"
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Prevent duplicate pending request
            |--------------------------------------------------------------------------
            */

            // Prevent duplicate pending requests
            $existingPending = $dm
                ->createQueryBuilder(TaskExtension::class)
                ->field('task')->references($task)
                ->field('status')->equals('pending')
                ->getQuery()
                ->getSingleResult();

            if ($existingPending) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    422,
                    null,
                    "An extension request is already pending for this task."
                );
            }

            $extension = new TaskExtension();

            $extension->setTask($task);

            $extension->setReason(
                $request->reason
            );

            $extension->setStatus('pending');

            $extension->setRequestedBy(
                $task->getCurrentAssignee()
            );


            if ($task->getDueAt()) {

                $extension->setPreviousDueAt(
                    clone $task->getDueAt()
                );
            }

            $dm->persist($extension);

            $dm->flush();

            $session->commitTransaction();

            return CommonHelper::response(
                true,
                201,
                [
                    'id' => $extension->getId()
                ],
                "Extension request submitted successfully"
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



    //approve extension
    public function approve(Request $request, string $extensionId, DocumentManager $dm)
    {

        $request->validate([

            'manager_id' => 'required|string',

            'new_due_at' => 'required|date',

            'reviewer_remarks' =>
            'nullable|string|max:1000'
        ]);

        $client = $dm->getClient();

        $session = $client->startSession();

        $session->startTransaction();

        try {

            $extension = $dm
                ->getRepository(TaskExtension::class)
                ->find($extensionId);

            if (!$extension) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Extension request not found"
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Only pending request can be approved
            |--------------------------------------------------------------------------
            */

            if (
                $extension->getStatus() !== 'pending'
            ) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    422,
                    null,
                    "This extension request has already been reviewed"
                );
            }

            $task = $extension->getTask();

            if (!$task) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Task not found"
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Manager validation
            |--------------------------------------------------------------------------
            */

            $manager = $dm
                ->getRepository(User::class)
                ->find($request->manager_id);

            if (!$manager) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Manager not found"
                );
            }

            $newDueAt = new DateTime(
                $request->new_due_at
            );

            /*
            |--------------------------------------------------------------------------
            | New due date must be greater than current due date
            |--------------------------------------------------------------------------
            */

            if (
                $task->getDueAt()
                && $newDueAt <= $task->getDueAt()
            ) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    422,
                    null,
                    "New due date must be greater than current due date"
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Approve extension
            |--------------------------------------------------------------------------
            */

            $extension->setStatus('approved');

            $extension->setNewDueAt($newDueAt);

            $extension->setReviewerRemarks(
                $request->reviewer_remarks
            );

            $extension->setReviewedBy($manager);

            $extension->setReviewedAt(
                new DateTime()
            );

            /*
            |--------------------------------------------------------------------------
            | Update task
            |--------------------------------------------------------------------------
            */

            $task->setDueAt(
                clone $newDueAt
            );

            $task->setIsSlaBreached(false);

            /*
            |--------------------------------------------------------------------------
            | DO NOT reset breach count
            |--------------------------------------------------------------------------
            */

            $task->setUpdatedBy($manager);

            $dm->flush();

            $session->commitTransaction();

            return CommonHelper::response(
                true,
                200,
                [
                    'task_id' => $task->getId(),
                    'extension_id' => $extension->getId()
                ],
                "Extension approved successfully"
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



  
    //reject extension
    public function reject(Request $request, string $extensionId, DocumentManager $dm) 
    {

        $request->validate([

            'manager_id' => 'required|string',

            'reviewer_remarks' =>
            'required|string|min:5|max:1000'
        ]);

        $client = $dm->getClient();

        $session = $client->startSession();

        $session->startTransaction();

        try {

            $extension = $dm
                ->getRepository(TaskExtension::class)
                ->find($extensionId);

            if (!$extension) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Extension request not found"
                );
            }


            if (
                $extension->getStatus() !== 'pending'
            ) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    422,
                    null,
                    "This extension request has already been reviewed"
                );
            }

            $manager = $dm
                ->getRepository(User::class)
                ->find($request->manager_id);

            if (!$manager) {

                $session->abortTransaction();

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Manager not found"
                );
            }


            $extension->setStatus('rejected');

            $extension->setReviewerRemarks(
                $request->reviewer_remarks
            );

            $extension->setReviewedBy($manager);

            $extension->setReviewedAt(
                new DateTime()
            );

            $dm->flush();

            $session->commitTransaction();

            return CommonHelper::response(
                true,
                200,
                null,
                "Extension request rejected successfully"
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
