    $(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    
    $('.press').click(function () {
        var cell = $(this).attr("id");
        $.ajax({
            url: '/tictactoe/turn',
            type: 'post',
            data: {_token: CSRF_TOKEN, message: cell},
            dataType: 'json',
            success: function (json) {
               
            $('#'+json.cell).html(json.symbol);

            }
        });
    });
    });