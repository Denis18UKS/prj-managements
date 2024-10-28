<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserRoleController extends Controller
{
    // Метод для назначения роли пользователю
    public function assignRole(Request $request, $userId)
    {
        // Получаем роль из запроса или используем 'user' по умолчанию
        $roleName = $request->input('role', 'user');
        Log::info("Назначение роли: получено имя роли '{$roleName}' для пользователя с ID {$userId}");

        // Проверяем существование роли
        $role = Role::firstOrCreate(['name' => $roleName, 'guard_name' => 'web']);
        Log::info("Роль найдена или создана: {$role->name}");

        // Находим пользователя по ID
        $user = User::find($userId);
        if (!$user) {
            Log::error("Пользователь с ID {$userId} не найден.");
            return response()->json(['message' => 'Пользователь не найден.'], 404);
        }

        // Удаляем все существующие роли пользователя
        $user->syncRoles([]);
        Log::info("Роли пользователя с ID {$userId} успешно очищены.");

        // Назначаем пользователю новую роль
        $user->assignRole($role);
        if ($user->hasRole($roleName)) {
            Log::info("Роль '{$roleName}' успешно назначена пользователю с ID {$userId}.");
            return response()->json(['message' => "Роль $roleName успешно назначена пользователю.", 'user' => $user, 'role' => $role]);
        } else {
            Log::error("Не удалось назначить роль '{$roleName}' пользователю с ID {$userId}.");
            return response()->json(['message' => "Не удалось назначить роль $roleName."], 500);
        }
    }
}
