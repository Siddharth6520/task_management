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
use App\Http\Controllers\WorkFlowTemplateController;
use App\Http\Controllers\WorkStagesController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TaskStatusHistoryController;
use App\Http\Controllers\TaskExtensionController;
use App\Http\Controllers\AttachmentController;
use App\Http\Controllers\TaskWorkflowController;


Route::post('/login', [AuthController::class, 'login']);

Route::middleware([\App\Http\Middleware\JwtMiddleware::class])->group(function () {

    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware([\App\Http\Middleware\JwtMiddleware::class, 'permission:USERS_VIEW'])->group(function () {
    Route::prefix('users')->group(function () {
        Route::get('/', [UserController::class, 'index']);
        Route::get('/{id}', [UserController::class, 'show']);
    });
});

Route::middleware([\App\Http\Middleware\JwtMiddleware::class, 'permission:USERS_CREATE'])->group(function () {
    Route::post('users', [UserController::class, 'store']);
});

Route::middleware([\App\Http\Middleware\JwtMiddleware::class, 'permission:USERS_EDIT'])->group(function () {
    Route::put('users/{id}', [UserController::class, 'update']);
});

Route::middleware([\App\Http\Middleware\JwtMiddleware::class, 'permission:USERS_DELETE'])->group(function () {
    Route::delete('users/{id}', [UserController::class, 'destroy']);
});

// ── Projects ──────────────────────────────────────────────────────────────
Route::middleware([\App\Http\Middleware\JwtMiddleware::class])->prefix('projects')->group(function () {

    Route::get('/', [ProjectsController::class, 'index'])
        ->middleware('permission:PROJECTS_VIEW');

    Route::post('/', [ProjectsController::class, 'store'])
        ->middleware('permission:PROJECTS_CREATE');

    Route::get('/{id}', [ProjectsController::class, 'show'])
        ->middleware('permission:PROJECTS_VIEW');

    Route::put('/{id}', [ProjectsController::class, 'update'])
        ->middleware('permission:PROJECTS_EDIT');

    Route::delete('/{id}', [ProjectsController::class, 'destroy'])
        ->middleware('permission:PROJECTS_DELETE');
});

// ── Teams ─────────────────────────────────────────────────────────────────
Route::middleware([\App\Http\Middleware\JwtMiddleware::class])->prefix('teams')->group(function () {

    Route::get('/', [TeamsController::class, 'index'])
        ->middleware('permission:TEAMS_VIEW');

    Route::post('/', [TeamsController::class, 'store'])
        ->middleware('permission:TEAMS_CREATE');

    Route::get('/{id}', [TeamsController::class, 'show'])
        ->middleware('permission:TEAMS_VIEW');

    Route::put('/{id}', [TeamsController::class, 'update'])
        ->middleware('permission:TEAMS_EDIT');

    Route::delete('/{id}', [TeamsController::class, 'destroy'])
        ->middleware('permission:TEAMS_DELETE');
});

// ── Role Permissions ──────────────────────────────────────────────────────

Route::get(
    'role-permissions',
    [RolePermissionController::class, 'index']
);

Route::post(
    'role-permissions',
    [RolePermissionController::class, 'store']
);

Route::get(
    'role-permissions/{id}',
    [RolePermissionController::class, 'show']
);

Route::put(
    'role-permissions/role/{roleId}',
    [RolePermissionController::class, 'update']
);

Route::delete(
    'role-permissions/{id}',
    [RolePermissionController::class, 'destroy']
);


// ── Team Members ──────────────────────────────────────────────────────────
Route::middleware([\App\Http\Middleware\JwtMiddleware::class])->prefix('team-members')->group(function () {

    Route::get('/', [TeamMemberController::class, 'index'])
        ->middleware('permission:TEAM_MEMBERS_VIEW');

    Route::post('/', [TeamMemberController::class, 'store'])
        ->middleware('permission:TEAM_MEMBERS_CREATE');

    Route::post('/bulk-upload', [TeamMemberController::class, 'bulk_store'])
        ->middleware('permission:TEAM_MEMBERS_CREATE');

    Route::get('/{id}', [TeamMemberController::class, 'show'])
        ->middleware('permission:TEAM_MEMBERS_VIEW');

    Route::put('/{id}', [TeamMemberController::class, 'update'])
        ->middleware('permission:TEAM_MEMBERS_EDIT');

    Route::delete('/{id}', [TeamMemberController::class, 'destroy'])
        ->middleware('permission:TEAM_MEMBERS_DELETE');
});

// ── Workflow Templates ────────────────────────────────────────────────────
Route::middleware([\App\Http\Middleware\JwtMiddleware::class])->prefix('workflow-templates')->group(function () {

    Route::get('/', [WorkFlowTemplateController::class, 'index'])
        ->middleware('permission:WORKFLOW_TEMPLATES_VIEW');

    Route::post('/', [WorkFlowTemplateController::class, 'store'])
        ->middleware('permission:WORKFLOW_TEMPLATES_CREATE');

    Route::get('/{id}', [WorkFlowTemplateController::class, 'show'])
        ->middleware('permission:WORKFLOW_TEMPLATES_VIEW');

    Route::put('/{id}', [WorkFlowTemplateController::class, 'update'])
        ->middleware('permission:WORKFLOW_TEMPLATES_EDIT');

    Route::delete('/{id}', [WorkFlowTemplateController::class, 'destroy'])
        ->middleware('permission:WORKFLOW_TEMPLATES_DELETE');
});

// ── Workflow Stages ───────────────────────────────────────────────────────
Route::middleware([\App\Http\Middleware\JwtMiddleware::class])->prefix('workflow-stages')->group(function () {

    Route::get('/', [WorkStagesController::class, 'index'])
        ->middleware('permission:WORKFLOW_STAGES_VIEW');

    Route::post('/', [WorkStagesController::class, 'store'])
        ->middleware('permission:WORKFLOW_STAGES_CREATE');

    Route::get('/{id}', [WorkStagesController::class, 'show'])
        ->middleware('permission:WORKFLOW_STAGES_VIEW');

    Route::put('/{id}', [WorkStagesController::class, 'update'])
        ->middleware('permission:WORKFLOW_STAGES_EDIT');

    Route::delete('/{id}', [WorkStagesController::class, 'destroy'])
        ->middleware('permission:WORKFLOW_STAGES_DELETE');
});

// ── Tasks ─────────────────────────────────────────────────────────────────
Route::middleware([\App\Http\Middleware\JwtMiddleware::class])->prefix('tasks')->group(function () {

    Route::get('/', [TaskController::class, 'index'])
        ->middleware('permission:TASKS_VIEW');

    Route::post('/', [TaskController::class, 'store'])
        ->middleware('permission:TASKS_CREATE');

    Route::get('/{id}', [TaskController::class, 'show'])
        ->middleware('permission:TASKS_VIEW');

    Route::put('/{id}', [TaskController::class, 'update'])
        ->middleware('permission:TASKS_EDIT');

    Route::delete('/{id}', [TaskController::class, 'destroy'])
        ->middleware('permission:TASKS_DELETE');

    // Task Extensions
    Route::post('/{taskId}/extensions', [TaskExtensionController::class, 'store'])
        ->middleware('permission:TASK_EXTENSIONS_CREATE');
});

// ── Task Status History ───────────────────────────────────────────────────
Route::middleware([\App\Http\Middleware\JwtMiddleware::class])->prefix('task-status-history')->group(function () {

    Route::get('/', [TaskStatusHistoryController::class, 'index'])
        ->middleware('permission:TASK_STATUS_HISTORY_VIEW');

    Route::get('/{id}', [TaskStatusHistoryController::class, 'show'])
        ->middleware('permission:TASK_STATUS_HISTORY_VIEW');
});

// ── Task Extensions ───────────────────────────────────────────────────────
Route::middleware([\App\Http\Middleware\JwtMiddleware::class])->prefix('task-extensions')->group(function () {

    Route::get('/', [TaskExtensionController::class, 'index'])
        ->middleware('permission:TASK_EXTENSIONS_VIEW');

    Route::get('/{id}', [TaskExtensionController::class, 'show'])
        ->middleware('permission:TASK_EXTENSIONS_VIEW');

    Route::post('/{extensionId}/approve', [TaskExtensionController::class, 'approve'])
        ->middleware('permission:TASK_EXTENSIONS_APPROVE');

    Route::post('/{extensionId}/reject', [TaskExtensionController::class, 'reject'])
        ->middleware('permission:TASK_EXTENSIONS_REJECT');
});

// ── Attachments ───────────────────────────────────────────────────────────
Route::middleware([\App\Http\Middleware\JwtMiddleware::class])->prefix('attachments')->group(function () {

    Route::get('/task/{taskId}', [AttachmentController::class, 'index'])
        ->middleware('permission:ATTACHMENTS_VIEW');

    Route::post('/task/{taskId}', [AttachmentController::class, 'store'])
        ->middleware('permission:ATTACHMENTS_CREATE');

    Route::get('/{id}/download', [AttachmentController::class, 'download'])
        ->middleware('permission:ATTACHMENTS_VIEW');

    Route::delete('/{id}', [AttachmentController::class, 'destroy'])
        ->middleware('permission:ATTACHMENTS_DELETE');

    Route::middleware([\App\Http\Middleware\JwtMiddleware::class])->prefix('tasks')->group(function () {
        Route::post('/{id}/transition', [TaskWorkflowController::class, 'transition'])
            ->middleware('permission:TASKS_EDIT');

        Route::get('/{id}/workflow', [TaskWorkflowController::class, 'workflow'])
            ->middleware('permission:TASKS_VIEW');
    });
});
