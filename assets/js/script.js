$(document).ready(function () {
    // TODO: Разобраться с [0] Элементами для вложености
    //TODO: Разобраться с this и [0] кашей для вложенных комментариев
    //обработчик саксэса для регистрации
    if (window.location.href.indexOf('reg=success') !== -1) {
        alert('Реєстрація пройшла успішно');
        history.pushState(null, null, window.location.origin + window.location.pathname);

    }
    // Обработчик ошибки авторизации
    if (window.location.href.indexOf('log=err') !== -1) {
        alert('Помилка авторизації, логін або пароль не вірні');
        history.pushState(null, null, window.location.origin + window.location.pathname);

    }

    //Редактирование комментария(вызов текст эрии)
    $('.comments-list').on('click', '.comment .edit',function (event)
    {
        var $this = $(this).closest('.comment').find('p')[0];
        var $this2 = $(this).closest('.comment').find('.spec')[0];
        $($this).hide();
        $($this2).removeClass('dis-none');

    });
    //Редактирование отмена редактирвоания
    $('.comments-list').on('click','.comment button[name=btn-cancel]', function (event)
    {
        var $this = $(this).closest('.comment').find('p')[0];
        var $this2 = $(this).closest('.comment').find('.spec')[0];
        $($this).show();
        $($this2).addClass('dis-none');

    });
    //Редактирование комментария(клик по кнопке сохранить), отправляет данные, при получении ответа скрывает текстареа и зануляет
    $('.comments-list').on('click', '.comment button[name=btn-save]',function (event){
        var thishtml = $(this);
        $.ajax({
            type: "POST", url: "ajax/edit", dataType: "json",
            data: {
                createdby:  $(this).closest('.comment').attr('data-user-id'),
                commentid: $(this).closest('.comment').attr('data-comment-id'),
                body: $(this).closest('.comment').find('textarea').val(),
            }, success: function (output) {
                var $this = thishtml.closest('.comment').find('p')[0];
                var $this2 = thishtml.closest('.comment').find('.spec')[0];
                $($this).html(thishtml.closest('.comment').find('textarea').val());
                $($this).show();

                $($this2).addClass('dis-none');
            }
        });
    });
    // Клик по "ответить", для добавление инпута или убирания
    $('.comments-list').on('click', '.comment .answer',function (event){

        var thishtml = $(this);
        var input = '<div class="input-group"> <input class="form-control" placeholder="Add a comment" type="text"> <span class="input-group-addon"> <a href="#"><i class="fa fa-edit"></i></a> </span> </div>';
        var obj =  $(this).closest('.comment').find('.comment-body')[0];
        //Велосипед из return false из-за многократной вложености и прохождение всего в цикле
        if ( $(obj).hasClass('input') == true) {
            $(obj).find('.input-group').remove();
            $(obj).removeClass('input');
        }else{
            $(obj).addClass('input');
            $(obj).append(input);

        }
        return false;
    });
    // Удаление комментария и всей ветви.
    $('.comments-list').on('click', '.comment .delete', function (event){
        var thishtml = $(this);
        $.ajax({
            type: "POST", url: "ajax/delete", dataType: "json",
            data: {
                createdby:  $(this).closest('.comment').attr('data-user-id'),
                commentid: $(this).closest('.comment').attr('data-comment-id'),
            }, success: function (output) {
                thishtml.closest('.comment').hide();
                //Инициализация звезд о5 и получение количества комментариев
                $('.post-description b').html(output.countcom);
                $(".starrr").starrr();
            }
        });
    });


    //Создание комментария
    //клик по энтеру
    $('.comments-list').on('keypress','.input-group input',(function(event){
        if(event.keyCode == 13){
            console.log('1');
            var $this = $(this).closest('.input-group').find('.fa.fa-edit')[0];
            $($this).click();
            return false;

        }
    }));
    //клик по кнопке
    $('.container').on('click', '.post-footer a i.fa',function (event) {
        var $this = $(this);
        $(this).closest('.input-group div').removeClass('has-error');
        event.preventDefault();
        if ($(this).closest('input-group').find('input').val() == ''){
            $(this).closest('.input-group div').addClass('has-error');
            return false;
        }
        $.ajax({
            type: "POST", url: "ajax/create", dataType: "json",
            data: {
                // Если .comment существует и унего есть коммент айди, то присвить его, в противном случае вернуть 0
                parent: (($(this).closest('.comment').attr('data-comment-id')  != null) ?  $(this).closest('.comment').attr('data-comment-id') : 0),
                body: $($this).closest('.input-group').find('input').val(),
            }, success: function (output) {
                $('.comments-list').html(output.comments);
                $('.post-footer input').val('');
                $('.post-description b').html(output.countcom);
                $(".starrr").starrr();
            }
        });


    });
    //обновить ленту(кнопка)
    $('.container .refresh').on('click', function (event) {

        event.preventDefault();
        $.ajax({
            type: "POST", url: "ajax/refresh", dataType: "json",
            data: {
            }, success: function (output) {
                // Получаем актуальные комменты, число комментариев и обновляем библиотеку звезд
                $('.comments-list').html(output.comments);
                $('.post-description b').html(output.countcom);
                $(".starrr").starrr();
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
    });
});