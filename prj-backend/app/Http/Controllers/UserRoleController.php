<?php

namespace App\Http\Controllers;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class UserRoleController extends Controller
{
    public function assignAdminRole()
    {
        // Создаём роль 'Admin' для guard 'web', если её ещё не существует
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);

        // Находим пользователя по id
        $user = User::find(5); // Замените 5 на id нужного пользователя

        if ($user) {
            // Удаляем все существующие роли пользователя
            $user->syncRoles([]);

            // Назначаем пользователю роль 'Admin'
            $user->assignRole($adminRole);

            // Проверяем, назначена ли роль успешно
            if ($user->hasRole('Admin')) {
                return response()->json([
                    'message' => 'Роль Admin успешно назначена пользователю.',
                    'user' => $user,
                    'role' => $adminRole,
                ]);
            } else {
                return response()->json([
                    'message' => 'Не удалось назначить роль Admin.',
                ], 500);
            }
        } else {
            return response()->json([
                'message' => 'Пользователь не найден.',
            ], 404);
        }
    }
}
