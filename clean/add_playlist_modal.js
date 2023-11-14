add_pl_modal = document.createElement('div');
add_pl_modal.id = 'addPlaylistModal';
add_pl_modal.style.display = 'none';

add_pl_modal.innerHTML = `
    <div class="modal-content">
        <span class="close">&times;</span>
        <form id="addPlaylistForm">
            <div class="pl_modal_opt">
                <input type="radio" id="existingPlaylist" name="playlistOption" value="existing" checked>
                <label for="existingPlaylist" class="pl_opt_label">Add to existing playlist</label>
                <select id="playlistSelect" class="pl_select">
                    <!-- options populated by PHP -->
                    ${playlist_options}
                </select>
            </div>
            <div class="pl_modal_opt">
                <input type="radio" id="newPlaylist" name="playlistOption" value="new">
                <label for="newPlaylist" class="pl_opt_label">Create new playlist</label>
                <input type="text" id="newPlaylistName" placeholder="New playlist name">
            </div>
            <input type="submit" value="Submit" id="submit_button_pl">
        </form>
    </div>
`;

// append the modal to the body
content_div.appendChild(add_pl_modal);
add_pl_modal.classList.add('animate');

// add event listener to show the modal when the add_pl button is clicked
document.getElementById('add_pl').addEventListener('click', () => {
    add_pl_modal.style.display = 'block';
});

// add event listener to close the modal when the close button is clicked
document.querySelector('#addPlaylistModal .close').addEventListener('click', () => {
    add_pl_modal.style.display = 'none';
});


// add event listener to handle form submission
submit_button_pl =document.getElementById("submit_button_pl");
document.getElementById('addPlaylistForm').addEventListener('submit', (event) => {
    event.preventDefault();
    submit_button_pl.value = "Submit";
    let playlistOption = document.querySelector('input[name=playlistOption]:checked').value;
    if (playlistOption === 'existing') {
        let playlist_id = document.getElementById('playlistSelect').value;
        // use AJAX to send a request to a PHP script to add the song to the selected playlist
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'add_to_playlist.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
        if (xhr.status === 200) {
            submit_button_pl.value = xhr.responseText + "\nReload to see changes";
            // alert(xhr.responseText + "\nReload to see changes");
        }
        };
        xhr.send(`song_id=${song_id}&playlist_id=${playlist_id}&user_id=${user_id}`);
    } else if (playlistOption === 'new') {
        let playlist_name = document.getElementById('newPlaylistName').value;
        // use AJAX to send a request to a PHP script to create a new playlist and add the song to it
        let xhr = new XMLHttpRequest();
        xhr.open('POST', 'create_playlist.php');
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onload = function() {
        if (xhr.status === 200) {
            submit_button_pl.value = xhr.responseText + "\nReload to see changes";
        }
        };
        xhr.send(`song_id=${song_id}&playlist_name=${playlist_name}&user_id=${user_id}`);
    }
});