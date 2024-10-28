<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Admin Sidebar</title>
</head>

<body>

    <nav class="nav">
        <div class="nav__logo">
            <p class="nav__logo-text">Название</p>
        </div>
        <div class="nav__menu">
            <p class="nav__menu-text">Меню</p>
            <ul class="nav__menu-list">
                <li class="nav__menu-item">
                    <a class="nav__menu-item-link" href="admin.php">Главная</a>
                </li>
                <li class="nav__menu-item">
                    <a class="nav__menu-item-link" href="users.php">Пользователи</a>
                </li>
                <li class="nav__menu-item">
                    <a class="nav__menu-item-link" href="tasks.php">Задачи</a>
                </li>
                <li class="nav__menu-item">
                    <a class="nav__menu-item-link" href="reports.php">Отчёты</a>
                </li>
            </ul>
            <div class="nav__menu-account">
                <p class="nav__menu-text">Аккаунт</p>
                <ul class="nav__menu-account-list">
                    <li class="nav__menu-item">
                        <a class="nav__menu-item-link" href="account.php">Аккаунт</a>
                    </li>
                </ul>
            </div>

            <button class="btn btn-dark" id="logout-button">Выйти</button>
        </div>
    </nav>

    <script>
        document.getElementById("logout-button").addEventListener("click", function () {
            fetch('http://prj-backend/logout', {
                method: 'POST',
                credentials: 'include',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message);
                        window.location.href = '/';
                    }
                })
                .catch(error => console.error("Ошибка выхода:", error));
        });
    </script>

</body>

</html>