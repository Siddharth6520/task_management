<?php

namespace App\Http\Controllers;

use App\Documents\User;
use App\Documents\Tasks;
use App\Documents\Attachment;
use App\Documents\WorkStage;
use App\Helpers\CommonHelper;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use Doctrine\ODM\MongoDB\DocumentManager;

class TaskAttachmentController extends Controller
{

    public function store(
        Request $request,
        string $taskId,
        DocumentManager $dm
    ) {

        $request->validate([

            'file' => [
                'required',
                'file',
                'max:10240',
                'mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx'
            ],

            'workflow_stage_id' => [
                'nullable',
                'string'
            ],

            'context' => [
                'nullable',
                'in:proof,screenshot,document,approval,rejection,stage_output'
            ],

            'uploaded_by' => [
                'required',
                'string'
            ]
        ]);

        try {

            $task = $dm
                ->getRepository(Tasks::class)
                ->find($taskId);

            if (!$task) {

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Task not found"
                );
            }

            $uploadedBy = $dm
                ->getRepository(User::class)
                ->find($request->uploaded_by);

            if (!$uploadedBy) {

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Uploader not found"
                );
            }

            $workflowStage = null;

            if ($request->filled('workflow_stage_id')) {

                $workflowStage = $dm
                    ->getRepository(WorkStage::class)
                    ->find($request->workflow_stage_id);

                if (!$workflowStage) {

                    return CommonHelper::response(
                        false,
                        404,
                        null,
                        "Workflow stage not found"
                    );
                }
            }

            $file = $request->file('file');

            $path = $file->store(
                "tasks/{$task->getId()}/attachments",
                'public'
            );

            $attachment = new Attachment();

            $attachment->setTask($task);

            $attachment->setWorkflowStage($workflowStage);

            $attachment->setFileName(
                $file->getClientOriginalName()
            );

            $attachment->setFilePath($path);

            $attachment->setMimeType(
                $file->getMimeType()
            );

            $attachment->setFileSizeBytes(
                $file->getSize()
            );

            $attachment->setContext(
                $request->context
            );

            $attachment->setUploadedBy(
                $uploadedBy
            );

            $dm->persist($attachment);

            $dm->flush();

            return CommonHelper::response(
                true,
                201,
                [
                    'id' => $attachment->getId()
                ],
                "Attachment uploaded successfully"
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



    /*
    |--------------------------------------------------------------------------
    | List Task Attachments
    |--------------------------------------------------------------------------
    */

    public function index(
        string $taskId,
        DocumentManager $dm
    ) {

        try {

            $task = $dm
                ->getRepository(Tasks::class)
                ->find($taskId);

            if (!$task) {

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Task not found"
                );
            }

            $attachments = $dm
                ->createQueryBuilder(Attachment::class)
                ->field('task')->references($task)
                ->sort('uploaded_at', 'desc')
                ->getQuery()
                ->execute();

            $data = [];

            foreach ($attachments as $attachment) {

                $data[] = [

                    'id' => $attachment->getId(),

                    'file_name' => $attachment->getFileName(),

                    'mime_type' => $attachment->getMimeType(),

                    'file_size_bytes' => $attachment->getFileSizeBytes(),

                    'context' => $attachment->getContext(),

                    'uploaded_at' => $attachment
                        ->getUploadedAt()?->format('Y-m-d H:i:s'),

                    'uploaded_by' => $attachment
                        ->getUploadedBy()?->getId(),

                    'workflow_stage_id' => $attachment
                        ->getWorkflowStage()?->getId()
                ];
            }

            return CommonHelper::response(
                true,
                200,
                $data,
                "Attachments fetched successfully"
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



    /*
    |--------------------------------------------------------------------------
    | Download Attachment
    |--------------------------------------------------------------------------
    */

    public function download(
        string $id,
        DocumentManager $dm
    ) {

        try {

            $attachment = $dm
                ->getRepository(Attachment::class)
                ->find($id);

            if (!$attachment) {

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Attachment not found"
                );
            }

            if (
                !Storage::disk('public')
                    ->exists($attachment->getFilePath())
            ) {

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "File not found in storage"
                );
            }

            return Storage::disk('public')->download($attachment->getFilePath(),$attachment->getFileName());

        } catch (\Throwable $e) {

            return CommonHelper::response(
                false,
                500,
                null,
                $e->getMessage()
            );
        }
    }



    public function destroy(
        string $id,
        DocumentManager $dm
    ) {

        try {

            $attachment = $dm
                ->getRepository(Attachment::class)
                ->find($id);

            if (!$attachment) {

                return CommonHelper::response(
                    false,
                    404,
                    null,
                    "Attachment not found"
                );
            }

            if (
                Storage::disk('public')
                    ->exists($attachment->getFilePath())
            ) {

                Storage::disk('public')->delete(
                    $attachment->getFilePath()
                );
            }

            $dm->remove($attachment);

            $dm->flush();

            return CommonHelper::response(
                true,
                200,
                null,
                "Attachment deleted successfully"
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
}