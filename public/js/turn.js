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

                $('#' + json.cell).html(json.symbol);
                if (json.end) {
                    switch (json.end)
                    {
                        case 0:
                            $('#lose').css('display', 'inline-block');
                            break;
                        case 1:
                            $('#tie').css('display', 'inline-block');
                            break;
                        case 2:
                            $('#win').css('display', 'inline-block');
                            break;
                    }
                }
                //console.log(json);

            }
        });
    });
}
);