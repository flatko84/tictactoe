
var evtSource = new EventSource("/update/" + game_id);
evtSource.addEventListener("ping", function (e) {

    var obj = JSON.parse(e.data);
    for (i = 0; i < obj.length; i++) {
$('#' + obj[i]).html(symbol);
        
    }
    // console.log(obj);

}, false);

