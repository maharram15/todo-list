<?php

use App\Http\Controllers\Api\V1\SessionController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/sessions', [SessionController::class, 'store']);
Route::post('/users', [UserController::class, 'store']);
Route::delete('/sessions', [SessionController::class, 'destroy'])->middleware('auth:sanctum');

Route::prefix('/tasks')->middleware('auth:sanctum')->group(static function () {
    Route::get('/', [TaskController::class, 'index']);
    Route::post('/', [TaskController::class, 'store']);
    Route::get('/{task_id}', [TaskController::class, 'show']);
    Route::patch('/{task_id}', [TaskController::class, 'update']);
    Route::delete('/{task_id}', [TaskController::class, 'destroy']);
});

