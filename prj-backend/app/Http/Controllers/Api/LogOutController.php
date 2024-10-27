<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LogOutController extends ApiController
{
    public function logout(): JsonResponse
    {
        Auth::logout(); // Выход текущего пользователя
        Log::info('Пользователь вышел из системы.');

        return response()->json(['message' => 'Вы успешно вышли из системы.'], 200);
    }
}
