$(document).ready(function() {
    if (window.location.href.indexOf('reg=success') !== -1)
    {
        alert('Реєстрація пройшла успішно');
        history.pushState(null, null, window.location.origin+window.location.pathname);

    }
    //Создание комментария
    $(document).on('click','.post-footer a i.fa',function (event) {

        $.ajax({
            type: "POST", url: "ajax/create", dataType: "json",
            data: {
                parent:'3',
                body:$('.post-footer input').val(),
            }, success: function (output) {

            }
        });


    });
    //Регистрация(проверка паролей)
    $('#form_register .btn').on('click',function (event) {

        $('#form_register input[name=password]').closest('.form-group').removeClass('has-error');
        $('#form_register input[name=confirm_password]').closest('.form-group').removeClass('has-error');
        if ($('#form_register input[name=password]').val() != $('#form_register input[name=confirm_password]').val() )
        {
            $('#form_register input[name=password]').closest('.form-group').addClass('has-error');
            $('#form_register input[name=confirm_password]').closest('.form-group').addClass('has-error');
            alert('Пароли не совпадают');
            event.preventDefault();
        }
        // $.ajax({
        //     type: "POST", url: "ajax/create", dataType: "json",
        //     data: {
        //         parent:'3',
        //         body:$('.post-footer input').val(),
        //     }, success: function (output) {
        //
        //     }
        // });


    });
});