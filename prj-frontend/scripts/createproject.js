$(document).ready(function () {
    $('createproject').submit(function (event) {
        event.preventDefault();

        $.ajax({
            url: 'http://prj-backend/api/create/project',
            type: 'POST',
            data: {
                email: $('#email').val(), // тут пишешь нужные тебе данные
                password: $('#password').val()
            },
            success: function (response) {
                console.log(response);
            },

            error: function (error) {
                console.log(error);
            }
        })
    })
})