<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;
use App\Http\Controllers\Api\HealthController;

Route::get('/health', HealthController::class);

Route::prefix('78682/v1')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});