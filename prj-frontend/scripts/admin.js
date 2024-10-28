
$(document).ready(function () {
    // Загрузка пользователей
    $.ajax({
        url: 'http://prj-backend/users',
        method: 'GET',
        dataType: 'json',
        success: function (data) {
            data.forEach(function (user) {
                const roles = user.roles.length ? user.roles.map(role => role.name).join(', ') : 'user';
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

                        const userRole = user.roles.length > 0 ? user.roles[0].name : 'user';
                        $('#editUserRole').val(userRole);

                        $('#editUserModal').show();
                        $('#saveUserChanges').data('id', userId);
                    },
                    error: function (xhr, status, error) {
                        console.error("Ошибка при загрузке пользователя:", error);
                    }
                });
            });

            // Обработчик кнопки удаления
            $('.delete_btn').on('click', function () {
                const userId = $(this).data('id');
                if (confirm("Вы уверены, что хотите удалить пользователя?")) {
                    $.ajax({
                        url: `http://prj-backend/users/${userId}`,
                        method: 'DELETE',
                        success: function () {
                            alert("Пользователь успешно удалён.");
                            location.reload();
                        },
                        error: function (xhr, status, error) {
                            console.error("Ошибка при удалении пользователя:", error);
                            alert('Ошибка при удалении пользователя.');
                        }
                    });
                }
            });
        },
        error: function (xhr, status, error) {
            console.error("Ошибка при загрузке пользователей:", error);
        }
    });

    // Сохранение изменений пользователя
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
                $.post(`http://prj-backend/users/${userId}/assign-role`, {
                    role: updatedUser.role
                })
                    .done(function () {
                        alert('Данные пользователя и роль успешно обновлены.');
                        $('#editUserModal').hide();
                        location.reload();
                    })
                    .fail(function (xhr, status, error) {
                        console.error("Ошибка при назначении роли:", error);
                        alert('Ошибка при назначении роли.');
                    });
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