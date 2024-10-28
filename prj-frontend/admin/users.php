<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пользователи</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/user.css">
    <!-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" defer></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../scripts/admin.js" defer></script>
</head>

<body>
    <?php include 'admin-sidebar.php'; ?> <!-- Включаем навигационную панель -->

    <!-- Основной контейнер -->
    <div class="container">
        <div class="filter">
            <form class="filter__search" action="" method="get">
                <input name="search" class="filter__search-input" type="text" placeholder="Найти пользователя">
                <button class="filter__search-button">
                    <img src="../images/icon-search.svg" alt="Поиск" class="filter__search-icon">
                </button>
            </form>
            <button class="filter__priority">Приоритетные</button>
            <button class="filter__reset">Сбросить</button>
            <div class="notifications">
                <img class="notifications-top" src="../images/notification-top.svg" alt="">
                <img class="notifications-bottom" src="../images/notification-bottom.svg" alt="">
            </div>
            <a class="filter__user-icon" href="account.php">
                <img src="../images/account-icon.png" alt="Профиль" class="filter__user-icon-img">
            </a>
        </div>

        <button class="add_user_btn" onclick="window.location.href='register.php'">Регистрация пользователя</button>
        <section class="projects">
            <h2 class="title">Пользователи</h2>
            <div class="projects__cards" id="user-cards">
                <!-- Карточки пользователей будут загружены здесь -->
            </div>
        </section>
    </div>

    <script>
        $(document).ready(function () {
            // Запрос на получение пользователей
            $.ajax({
                url: 'http://prj-backend/users', // Замените на ваш путь к API
                method: 'GET',
                dataType:'json',
                success: function (data) {
                    // console.log(data); // Выводим данные в консоль для отладки
                    data.forEach(function (user) {
                        // lsdjfolsd
                        $('#user-cards').append(`
                            <div class="projects__card">
                                <div class="projects__card-title">${user.name}</div>
                                <div class="projects__card-manager">${user.email}</div>
                                <div id="btns">
                                    <button class="edit_btn">Редактировать</button>
                                    <button class="delete_btn">Удалить</button>
                                </div>
                            </div>
                        `);
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Ошибка при загрузке пользователей:", error);
                    console.log("Ответ от сервера:", xhr.responseText); // Выводим ответ сервера
                }
            });
        });
    </script>
</body>

</html>