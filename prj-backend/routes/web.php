<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;

Route::get('/users', [UserController::class, 'index']);

Route::get('/managers', [UserController::class, 'managers']);
Route::get('/executors', [UserController::class, 'executors']);

Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');

Route::post('/users/{userId}/assign-role', [UserRoleController::class, 'assignRole']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


// Проекты
Route::get('/projects', [ProjectController::class, 'index']);
Route::get('/projects/{id}', [ProjectController::class, 'show']);
Route::post('/projects', [ProjectController::class, 'store']);
Route::put('/projects/{id}', [ProjectController::class, 'update']);
Route::delete('/projects/{id}', [ProjectController::class, 'destroy']);

// Задачи
Route::get('/tasks', [TaskController::class, 'index']);
Route::get('/tasks/{id}', [TaskController::class, 'show']);
Route::post('/tasks', [TaskController::class, 'store']);
Route::put('/tasks/{id}', [TaskController::class, 'update']);
Route::delete('/tasks/{id}', [TaskController::class, 'destroy']);
