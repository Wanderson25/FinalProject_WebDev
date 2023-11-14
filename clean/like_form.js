let like = document.getElementById("favorite");
console.log(is_like);
like_button(is_like);
function toggleLike() {
    is_like = !is_like;
    like_button(is_like);
}

function like_button(is_liked) {
    if(is_liked) {
        like.textContent = "♥";
        like.classList.add("activated");
    } else {
        like.textContent = "♡";
        like.classList.remove("activated");
    }
}
like.addEventListener('click', () => {
    // console.log("hehe like clicked");
    let action = is_like ? 'unlike' : 'like';

    // use AJAX to send a request to a PHP script to update the like status of the song
    let xhr = new XMLHttpRequest();
    xhr.open('POST', 'like.php');
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (xhr.status === 200) {
            special_message.innerHTML = xhr.responseText;
            // alert(xhr.responseText);
            is_like = !is_like;
            like_button(is_like);
        }
    };
    xhr.send(`song_id=${song_id}&action=${action}&user_id=${user_id}`);
});