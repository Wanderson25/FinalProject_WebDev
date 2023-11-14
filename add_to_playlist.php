<?php
    include_once('config.php');

    // get the song_id and playlist_id from the POST data
    $song_id = $_POST['song_id'];
    $playlist_id = $_POST['playlist_id'];

    // add the song to the playlist
    $query = "INSERT INTO playlist_songs (song_id, playlist_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $song_id, $playlist_id);
    if (mysqli_stmt_execute($stmt)) {
        // return a success message
        echo "Song added to playlist successfully!";
    } else {
        // return an error message
        echo "Error: Song already in playlist" . mysqli_stmt_error($stmt);
    }
?>