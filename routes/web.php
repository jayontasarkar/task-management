<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])
        ->name('home');
Route::get('/projects/{project}/tasks', [TaskController::class, 'render'])
        ->name('tasks.index');
