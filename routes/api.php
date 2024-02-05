<?php

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\SortTaskPriorityController;
use App\Http\Controllers\TaskController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/projects', ProjectController::class)
        ->only(['index', 'store', 'update', 'destroy']);
Route::get('/projects/{project}/tasks', [TaskController::class, 'index'])
        ->name('api.tasks.index');

Route::post('tasks/priority', SortTaskPriorityController::class);

Route::apiResource('/tasks', TaskController::class)
        ->only(['store', 'update', 'destroy']);
