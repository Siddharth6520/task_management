<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProjectsController;
use App\Http\Controllers\TeamsController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\TeamMemberController;
use App\Http\Controllers\WorkflowTemplateController;
use App\Http\Controllers\WorkflowStageController;
use App\Http\Controllers\TasksController;
use App\Http\Controllers\TaskStatusHistoryController;
use App\Http\Controllers\TaskExtensionController;
use App\Http\Controllers\AttachmentController;



Route::post('/login', [AuthController::class, 'login']);
Route::prefix('users')->group(function () {

    Route::get('/', [UserController::class, 'index']);

    Route::post('/', [UserController::class, 'store']);

    Route::get('/{id}', [UserController::class, 'show']);

    Route::put('/{id}', [UserController::class, 'update']);

    Route::delete('/{id}', [UserController::class, 'destroy']);
});


Route::middleware('jwt.auth')->group(function () {


    Route::get('/me', [AuthController::class, 'me']);

    Route::post('/refresh', [AuthController::class, 'refresh']);

    Route::post('/logout', [AuthController::class, 'logout']);







    Route::prefix('projects')->group(function () {

        Route::get('/', [ProjectsController::class, 'index']);

        Route::post('/', [ProjectsController::class, 'store']);

        Route::get('/{id}', [ProjectsController::class, 'show']);

        Route::put('/{id}', [ProjectsController::class, 'update']);

        Route::delete('/{id}', [ProjectsController::class, 'destroy']);
    });


    //teams

    Route::prefix('teams')->group(function () {

        Route::get('/', [TeamsController::class, 'index']);

        Route::post('/', [TeamsController::class, 'store']);

        Route::get('/{id}', [TeamsController::class, 'show']);

        Route::put('/{id}', [TeamsController::class, 'update']);

        Route::delete('/{id}', [TeamsController::class, 'destroy']);
    });



    //rolepermissions
    Route::prefix('role-permissions')->group(function () {

        Route::get('/', [RolePermissionController::class, 'index']);

        Route::post('/', [RolePermissionController::class, 'store']);

        Route::get('/{id}', [RolePermissionController::class, 'show']);

        Route::put('/{id}', [RolePermissionController::class, 'update']);

        Route::delete('/{id}', [RolePermissionController::class, 'destroy']);
    });


    //team members

    Route::prefix('team-members')->group(function () {

        Route::get('/', [TeamMemberController::class, 'index']);

        Route::post('/', [TeamMemberController::class, 'store']);

        Route::post(
            '/bulk-upload',
            [TeamMemberController::class, 'bulk_store']
        );

        Route::get('/{id}', [TeamMemberController::class, 'show']);

        Route::put('/{id}', [TeamMemberController::class, 'update']);

        Route::delete('/{id}', [TeamMemberController::class, 'destroy']);
    });



    //workflow templates    

    // Route::prefix('workflow-templates')->group(function () {

    //     Route::get('/', [WorkflowTemplateController::class, 'index']);

    //     Route::post('/', [WorkflowTemplateController::class, 'store']);

    //     Route::get('/{id}', [WorkflowTemplateController::class, 'show']);

    //     Route::put('/{id}', [WorkflowTemplateController::class, 'update']);

    //     Route::delete('/{id}', [WorkflowTemplateController::class, 'destroy']);

    // });



    //workflow stages   
    // Route::prefix('workflow-stages')->group(function () {

    //     Route::get('/', [WorkflowStageController::class, 'index']);

    //     Route::post('/', [WorkflowStageController::class, 'store']);

    //     Route::get('/{id}', [WorkflowStageController::class, 'show']);

    //     Route::put('/{id}', [WorkflowStageController::class, 'update']);

    //     Route::delete('/{id}', [WorkflowStageController::class, 'destroy']);

    // });



    //tasks

    Route::prefix('tasks')->group(function () {

        Route::get('/', [TasksController::class, 'index']);

        Route::post('/', [TasksController::class, 'store']);

        Route::get('/{id}', [TasksController::class, 'show']);

        Route::put('/{id}', [TasksController::class, 'update']);

        Route::delete('/{id}', [TasksController::class, 'destroy']);
    });



    //task status history

    Route::prefix('task-status-history')->group(function () {

        Route::get(
            '/',
            [TaskStatusHistoryController::class, 'index']
        );

        Route::get(
            '/{id}',
            [TaskStatusHistoryController::class, 'show']
        );
    });



    //task extension requests

    Route::prefix('tasks')->group(function () {

        /*
    |--------------------------------------------------------------------------
    | Task Extension Requests
    |--------------------------------------------------------------------------
    */

        Route::post(
            '/{taskId}/extensions',
            [TaskExtensionController::class, 'store']
        );
    });

    Route::prefix('task-extensions')->group(function () {

        Route::get(
            '/',
            [TaskExtensionController::class, 'index']
        );

        Route::get(
            '/{id}',
            [TaskExtensionController::class, 'show']
        );

        Route::post(
            '/{extensionId}/approve',
            [TaskExtensionController::class, 'approve']
        );

        Route::post(
            '/{extensionId}/reject',
            [TaskExtensionController::class, 'reject']
        );
    });



    //attachments

    Route::prefix('attachments')->group(function () {

        Route::get(
            '/task/{taskId}',
            [AttachmentController::class, 'index']
        );

        Route::post(
            '/task/{taskId}',
            [AttachmentController::class, 'store']
        );

        Route::get(
            '/{id}/download',
            [AttachmentController::class, 'download']
        );

        Route::delete(
            '/{id}',
            [AttachmentController::class, 'destroy']
        );
    });
});
