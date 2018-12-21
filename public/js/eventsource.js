
var evtSource = new EventSource("/update/" + game_id);
evtSource.addEventListener("turn", function (e) {

    var obj = JSON.parse(e.data);
    //console.log(obj['turn']);
    $('#' + obj['turn']).html(symbol);
    $('#messages').html("User " + obj['user'] + " joined.");

//console.log(obj);
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


