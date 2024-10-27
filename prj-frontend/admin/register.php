<?php
session_start(); // Если сессии не включены, убедитесь, что они запускаются

// Функция для проверки, является ли пользователь авторизованным
function isAuthorized($requiredRole)
{
    return isset($_SESSION['user']) && $_SESSION['user']['role'] === $requiredRole;
}

// Проверяем, является ли пользователь авторизованным администратором
if (!isAuthorized('admin')) {
    header('HTTP/1.0 403 Forbidden');
    echo 'У вас нет прав для доступа к этой странице.';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Регистрация</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/sign.css">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script src='../scripts/register.js' defer></script>
</head>

<body>
    <!-- <button class="backing_btn" onclick="window.location.href='admin.html'">Назад</button> -->

    <div class="container">
        <section class="sign-in">
            <form id="register" action="" method="post">
                <h1 class="title">Регистрация</h1>
                <div class="form__item">
                    <label for="email">Имя</label>
                    <input name="username" type="text" id="username" placeholder="Введите имя">
                </div>

                <div class="form__item">
                    <label for="email">Почта</label>
                    <input name="email" type="email" id="email" placeholder="Введите почту">
                </div>

                <div class="form__item">
                    <label for="password">Пароль</label>
                    <input name="password" type="password" id="password" placeholder="Введите пароль">
                </div>

                <!-- <div class="form__item">
                    <label for="login">Роль</label>
                    <select name="role" id="role">
                        <option value="" disabled selected>Выберите роль</option>
                        <option value="1">Руководитель</option>
                        <option value="2">Исполнитель</option>
                    </select>
                </div> -->

                <button type="submit" class="form__btn">Зарегистрировать</button>
            </form>
            <div class="background__img sign-up">
                <div class="blur">
                    <div class="blur__stars">
                        <img src="images/star.png" alt="">
                        <img src="images/star.png" alt="">
                        <img src="images/star.png" alt="">
                        <img src="images/star.png" alt="">
                        <img src="images/star.png" alt="">
                    </div>
                    <p class="blur__text">Инструмент управления панелью управления упростил отслеживание задач и
                        значительно повысил производительность команды.</p>
                    <div class="blur__author">Кэтрин Мёрфи</div>
                    <div class="blur__position">Координатор по маркетингу</div>
                </div>
            </div>
        </section>
    </div>
</body>

</html>