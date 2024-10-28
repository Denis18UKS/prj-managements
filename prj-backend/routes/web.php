<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/users', [UserController::class, 'index']);

Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);

Route::post('/users/{userId}/assign-role', [UserRoleController::class, 'assignRole']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


