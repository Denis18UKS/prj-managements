<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Пользователи</title>
    <link rel="stylesheet" href="../styles/main.css">
    <link rel="stylesheet" href="../styles/user.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../scripts/admin.js" defer></script>
</head>

<body>
    <?php include 'admin-sidebar.php'; ?>

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
            <div class="projects__cards" id="user-cards"></div>
        </section>
    </div>

    <!-- Модальное окно для редактирования пользователя -->
    <div id="editUserModal" style="display:none;">
        <h3>Редактировать пользователя</h3>
        <input type="text" id="editUserName" placeholder="Имя пользователя" required>
        <input type="email" id="editUserEmail" placeholder="Email" required>
        <label for="editUserRole">Роль:</label>
        <select id="editUserRole">
            <!-- Роли будут загружены динамически -->
        </select>
        <button id="saveUserChanges">Сохранить изменения</button>
        <button id="closeModal">Закрыть</button>
    </div>

    <script>
        $(document).ready(function () {
            // Загрузка пользователей
            $.ajax({
                url: 'http://prj-backend/users',
                method: 'GET',
                dataType: 'json',
                success: function (data) {
                    data.forEach(function (user) {
                        const roles = user.roles.map(role => role.name).join(', ');
                        $('#user-cards').append(`
                            <div class="projects__card">
                                <div class="projects__card-title">${user.name}</div>
                                <div class="projects__card-manager">${user.email}</div>
                                <div class="projects__card-role">Роль: ${roles}</div>
                                <div id="btns">
                                    <button class="edit_btn" data-id="${user.id}">Редактировать</button>
                                    <button class="delete_btn" data-id="${user.id}">Удалить</button>
                                </div>
                            </div>
                        `);
                    });

                    // Открытие модального окна редактирования
                    $('.edit_btn').on('click', function () {
                        const userId = $(this).data('id');
                        $.ajax({
                            url: `http://prj-backend/users/${userId}`,
                            method: 'GET',
                            dataType: 'json',
                            success: function (user) {
                                $('#editUserName').val(user.name);
                                $('#editUserEmail').val(user.email);
                                $('#editUserRole').empty();
                                user.roles.forEach(function (role) {
                                    $('#editUserRole').append(`<option value="${role.name}">${role.name}</option>`);
                                });
                                $('#editUserModal').show();
                                $('#saveUserChanges').data('id', userId);
                            }
                        });
                    });
                },
                error: function (xhr, status, error) {
                    console.error("Ошибка при загрузке пользователей:", error);
                }
            });

            // Сохранение изменений
            $('#saveUserChanges').on('click', function () {
                const userId = $(this).data('id');
                const updatedUser = {
                    name: $('#editUserName').val(),
                    email: $('#editUserEmail').val(),
                    role: $('#editUserRole').val()
                };

                $.ajax({
                    url: `http://prj-backend/users/${userId}`,
                    method: 'PUT',
                    contentType: 'application/json',
                    data: JSON.stringify(updatedUser),
                    success: function () {
                        alert('Данные пользователя успешно обновлены.');
                        $('#editUserModal').hide();
                        location.reload();
                    },
                    error: function (xhr, status, error) {
                        console.error("Ошибка при обновлении пользователя:", error);
                        alert('Ошибка при обновлении пользователя.');
                    }
                });
            });

            // Закрытие модального окна
            $('#closeModal').on('click', function () {
                $('#editUserModal').hide();
            });
        });
    </script>
</body>

</html>