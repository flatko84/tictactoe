$(document).ready(function () {
    
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $('.press').click(function () {
        var cell = $(this).attr("id");
        $.ajax({
            url: '/pool/turn',
            type: 'post',
            data: {_token: CSRF_TOKEN, message: cell},
            dataType: 'json',
            success: function (json) {
                console.log(json);
                $('#' + json.cell).attr("src", json.symbol + '.png');
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
            }
        });
    });
}
);