$(document).ready(function() {
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
});