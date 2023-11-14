var coll = document.getElementsByClassName("collapsible");
var i;

for (let i = 0; i < coll.length; i++) {
    coll[i].addEventListener("click", function() {
        this.classList.toggle("active");
        let content = this.nextElementSibling;
        content.style.maxHeight = (content.style.maxHeight) ? null : content.scrollHeight + "px";
    });
}

const playlistToggle = document.getElementById("playlist-toggle");
const commentsToggle = document.getElementById("comments-toggle");
const interfaceDiv = document.querySelector(".interface");

let cm_div = document.querySelector('.cm');
const cm_it = document.querySelectorAll(".cm_it, .s_cm");

let pl_items = document.querySelectorAll('.pl_link');
const pl_playlist = document.querySelector(".pl");

let tl_items = document.querySelectorAll('.tl_link');
const tl_tracklist = document.querySelector(".tl");
let tl_button = document.querySelectorAll('.collapsible');

let playlist_is_big = false;
let comment_is_big = false;
let pl_items_color_toggle = false;
let burger = "☰";

// if not logged in
if(user_id == -1) {
    tl_tracklist.classList.add("playlist_small");
    pl_playlist.classList.add("playlist_small");
    pl_playlist.style.color = "white";
    tl_tracklist.style.height = "80%";
}

function reset_interface_div() {
    remove_classes([interfaceDiv], [
        "comments_small",
        "playlist_small",
    ]);

    remove_classes(cm_it, [
        "playlist_big"
    ]);

    edit_styles([tl_tracklist, pl_playlist], {color: "white"});
    // edit_styles(tl_items, {color: "white"});   
    // edit_styles(pl_items, {color: "white"});     
    edit_styles(tl_button, {color: "white"}); 

    playlistToggle.textContent = "Playlist";
    commentsToggle.textContent = "Comments";
}

playlistToggle.addEventListener("click", function() {
    playlist_is_big = !playlist_is_big;
    reset_interface_div();
    if(playlist_is_big) {
        interfaceDiv.classList.add("comments_small");
        commentsToggle.textContent = burger;
        add_classes(cm_it, ["playlist_big"]);
    }
});

commentsToggle.addEventListener("click", function() {
    comment_is_big = !comment_is_big;
    reset_interface_div();
    if(comment_is_big) {
        interfaceDiv.classList.add("playlist_small");
        playlistToggle.textContent = burger;
        edit_styles([tl_tracklist, pl_playlist], {color: "rgba(0,0,0,0)"}); 
        edit_styles(tl_items, {color: "rgba(0,0,0,0)"});   
        edit_styles(pl_items, {color: "rgba(0,0,0,0)"});     
        edit_styles(tl_button, {color: "rgba(0,0,0,0)"});     
    }
});

playerDiv.addEventListener("click", function() {
    playlist_is_big = false;
    comment_is_big = false;
    reset_interface_div();
})


if(user_id != -1 ) {
    tl_tracklist.addEventListener("click", function(event) {
    pl_items_color_toggle = !pl_items_color_toggle;
    // console.log(event.target.classList.contains("collapsible"), "tracklist");
    if(!event.target.classList.contains("collapsible")) {
        if(pl_items_color_toggle) {
            add_classes([tl_tracklist, pl_playlist], ["playlist_small"]);
            edit_styles(pl_items, {color: "rgba(0,0,0,0)"}); 
        } else {
            remove_classes([tl_tracklist, pl_playlist], ["playlist_small"]);
            edit_styles(pl_items, {color: "white"}); 
        }

    }
});
}