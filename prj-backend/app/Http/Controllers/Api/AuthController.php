<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\Api\UserLoginRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class AuthController extends ApiController
{
    public function login(UserLoginRequest $loginRequest): JsonResponse
    {
        // Получаем данные для аутентификации из запроса
        $credentials = $loginRequest->only(['email', 'password']);
        Log::info('Попытка входа с данными:', $credentials);

        // Пытаемся выполнить аутентификацию
        if (Auth::attempt($credentials, true)) {
            $user = Auth::user(); // Получаем текущего аутентифицированного пользователя
            Log::info('Успешный вход для пользователя:', ['id' => $user->id]);

            // Проверка роли пользователя
            $role = $user->roles->first(); // Получаем первую роль пользователя

            // Определяем URL для редиректа на основе роли
            $redirectUrl = ($role && $role->name === 'Admin') ? url('http://prj-frontend/admin/users.php') : url('/projects-and-tasks');

            // Возвращаем успешный ответ с информацией о пользователе и URL для редиректа
            return response()->json([
                'message' => 'Вход выполнен успешно.',
                'user' => new UserResource($user),
                'redirect_url' => $redirectUrl
            ], 200);
        }

        // В случае неудачной попытки возвращаем ошибку
        return $this->sendError('Неверное имя пользователя или пароль.', Response::HTTP_UNAUTHORIZED);
    }
}
