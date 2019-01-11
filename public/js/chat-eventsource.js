var evtSource = new EventSource("/chat/" + game_id);
evtSource.addEventListener("chat", function (e) {

    var obj = JSON.parse(e.data);
    //console.log(obj['turn']);

    $('#chat-window').append("<br>" + obj['chat'] + "<br>");

console.log(obj);
    if (obj['end']) {
        switch (obj['end'])
        {
            case '0':
                $('#win').css('display', 'inline-block');
                break;
            case '1':
                $('#tie').css('display', 'inline-block');
                break;
            case '2':
                $('#lose').css('display', 'inline-block');
                break;
        }
    }

}, false);


