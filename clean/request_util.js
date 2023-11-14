function send_form_request(form_data, form_destination, callback, method="POST") {
    var xhr = new XMLHttpRequest();
    xhr.open(method, form_destination, true);
    
    xhr.onload = function() {
        if (xhr.status === 200) {
            var response = xhr.responseText;
            var data = JSON.parse(response);
            callback(data);
        } else {
            console.error("Error: " + xhr.statusText);
            callback(null);
        }
    };

    xhr.send(form_data);
}