let text = document.querySelector("#rainbow-text");
load_rainbow_text(0.05, text);
let loading = document.getElementById("loading");
let duration_item = document.getElementById("duration");
let song_file_input = document.querySelector("#song_url");

song_file_input.addEventListener("change", function() {
    var file = this.files[0];
    calculate_song_duration(file, function(duration) {
        update_duration(duration);
    });
});

function search_song_info() {
    loading_text("loading", "Searching");
    var form_data = get_form_data();
    if (form_data) {
        
        send_search_info_request(form_data);
    } else {
        nofile_searching();
    }
}

function get_form_data() {
    var file_input = document.getElementById("song_url");
    var song_title = document.getElementById("song_title").value;
    var song_artist = document.getElementById("song_artist").value;

    if (!file_input.files || !file_input.files[0]) {
        return null;
    }

    var file = file_input.files[0];
    var form_data = new FormData();
    form_data.append("song_url", file);
    form_data.append("song_title", song_title);
    form_data.append("song_artist", song_artist);
    return form_data;
}

function send_search_info_request(form_data) {
    send_form_request(form_data, "song_info_search.php", function(data) {
        if(data) {
            // console.log(data);
            fill_fields(data);
            done_searching();
        } else {
            failed_searching();
        }
    }, "POST");
}

function fill_fields(data) {
    document.getElementById("song_title").value = data.song_title;
    document.getElementById("song_artist").value = data.song_artist;
    document.getElementById("song_date").value = data.date;

    if (data.cover_art) {
        document.getElementById("cover_url").value = data.cover_art;
        document.querySelector(".cover-image").src = data.cover_art;
    }
    if (data.song_id) {
        document.getElementById("song_id").value = data.song_id;
    }
}

function done_searching() {
    loading.innerHTML = "Done!";
}

function failed_searching() {
    loading.innerHTML = "No info found!";
}

function nofile_searching() {
    loading.innerHTML = "Please choose a file!";
}


function update_duration(duration) {
    duration_item.value = duration;
}    