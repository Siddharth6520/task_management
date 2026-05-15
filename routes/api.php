<?php

use App\Http\Controllers\TeamMemberController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\WorkTemplateController;
use App\Http\Controllers\WorkStagesController;

Route::post('/login', [AuthController::class, 'login']);
Route::middleware(\App\Http\Middleware\JwtMiddleware::class)->group(function () {
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::get('work-templates', [WorkTemplateController::class, 'index']);
    Route::post('work-templates', [WorkTemplateController::class, 'store']);
    Route::get('work-templates/{id}', [WorkTemplateController::class, 'show']);
    Route::put('work-templates/{id}', [WorkTemplateController::class, 'update']);
    Route::delete('work-templates/{id}', [WorkTemplateController::class, 'destroy']);

    Route::get('work-stages', [WorkStagesController::class, 'index']);
    Route::post('work-stages', [WorkStagesController::class, 'store']);
    Route::get('work-stages/{id}', [WorkStagesController::class, 'show']);
    Route::put('work-stages/{id}', [WorkStagesController::class, 'update']);
    Route::delete('work-stages/{id}', [WorkStagesController::class, 'destroy']);
});
?>