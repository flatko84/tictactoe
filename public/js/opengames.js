var evtSource = new EventSource("/opengames");
evtSource.addEventListener("ping", function (e) {

    var games = JSON.parse(e.data);
    var text = '';
    for (i = 0; i < games.length; i++) {
        text += '<a href="/' + games[i].game_type + '/' + games[i].game_id + '">' + games[i].name + '</a> - ' + games[i].game_type;
    }
    $('#open-games').html(text);



}, false);


