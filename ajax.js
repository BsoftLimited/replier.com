function request(url, jsonRequest, func){
	var xmlhttp = new XMLHttpRequest();
	//xmlhttp.setRequestHeader("Content-Type", "application/json");
	xmlhttp.onreadystatechange = function() {
		if (xmlhttp.readyState == 4) {
			func(xmlhttp.status, JSON.parse(xmlhttp.responseText));
		}
	}
	xmlhttp.open("POST", url, true);
	xmlhttp.send(JSON.stringify(jsonRequest));
}