<?php

use App\Http\Controllers\Api\LogOutController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

Route::get('/users', [UserController::class, 'index']);
Route::post('/logout', [LogOutController::class, 'logout'])->name('logout');
