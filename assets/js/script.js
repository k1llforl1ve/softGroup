$(document).ready(function () {
    if (window.location.href.indexOf('reg=success') !== -1) {
        alert('Реєстрація пройшла успішно');
        history.pushState(null, null, window.location.origin + window.location.pathname);

    }
    if (window.location.href.indexOf('log=err') !== -1) {
        alert('Помилка авторизації, логін або пароль не вірні');
        history.pushState(null, null, window.location.origin + window.location.pathname);

    }
    $('.comment button[name=btn-save]').on('click', function (event){
        var thishtml = $(this);
        $.ajax({
            type: "POST", url: "ajax/edit", dataType: "json",
            data: {
                createdby:  $(this).closest('.comment').attr('data-user-id'),
                commentid: $(this).closest('.comment').attr('data-comment-id'),
                body: $(this).closest('.comment').find('textarea').val(),
            }, success: function (output) {
                thishtml.closest('.comment').find('p').html(thishtml.closest('.comment').find('textarea').val());
                thishtml.closest('.comment').find('p').show();
                thishtml.closest('.comment').find('.spec').addClass('dis-none');
            }
        });
    });
    $('.comments-list').on('click', '.comment .delete', function (event){
        var thishtml = $(this);
        $.ajax({
            type: "POST", url: "ajax/delete", dataType: "json",
            data: {
                createdby:  $(this).closest('.comment').attr('data-user-id'),
                commentid: $(this).closest('.comment').attr('data-comment-id'),
            }, success: function (output) {
                thishtml.closest('.comment').hide();
            }
        });
    });
    //Редактирование комментария
    $('.comments-list').on('click', '.comment .edit',function (event)
    {

        $(this).closest('.comment').find('p').hide();
        $(this).closest('.comment').find('.spec').removeClass('dis-none');

    });
    //Редактирование отмена редактирвоания
    $('.comment button[name=btn-cancel]').on('click', function (event)
    {

        $(this).closest('.comment').find('p').show();
        $(this).closest('.comment').find('.spec').addClass('dis-none');

    });
    //Создание комментария
    $('.post-footer a i.fa').on('click', function (event) {

        event.preventDefault();
        $.ajax({
            type: "POST", url: "ajax/create", dataType: "json",
            data: {
                parent: '3',
                body: $('.post-footer input').val(),
            }, success: function (output) {
                $('.comments-list').html(output.comments);
                $('.post-footer input').val('');
                $('.post-description b').html(parseInt($('.post-description b').html()) + 1);
            }
        });


    });
    //Регистрация(проверка паролей)
    $('#form_register .btn').on('click', function (event) {

        $('#form_register input[name=password]').closest('.form-group').removeClass('has-error');
        $('#form_register input[name=confirm_password]').closest('.form-group').removeClass('has-error');
        if ($('#form_register input[name=password]').val() != $('#form_register input[name=confirm_password]').val()) {
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