
var evtSource = new EventSource("/update");
evtSource.addEventListener("ping", function(e) {
  
  var obj = JSON.parse(e.data);
	
//document.getElementById('time').value = obj.time;
  console.log(obj);

}, false);

