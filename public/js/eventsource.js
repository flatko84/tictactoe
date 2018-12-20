
var evtSource = new EventSource("/update/" + game_id);
evtSource.addEventListener("ping", function (e) {

    var obj = JSON.parse(e.data);
    for (i = 0; i < obj['turn'].length; i++) {
        $('#' + obj['turn'][i]).html(symbol);
    }
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

