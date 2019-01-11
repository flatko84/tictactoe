$(document).ready(function () {
    var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
    $('#send-button').click(function () {
        var message = $('#send-text').val();
        $.ajax({
            url: '/game/chat',
            type: 'post',
            data: {_token: CSRF_TOKEN, message: message},
            dataType: 'json',
            success: function (json) {

                $('#chat-window').append("<br>" + json + "<br>");
                
                console.log(json);

            }
        });
    });
}
);