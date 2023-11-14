<?php
    include_once('config.php');

    // get the playlist_name and song_id from the POST data
    $playlist_name = $_POST['playlist_name'];
    $song_id = $_POST['song_id'];
    $user_id = $_POST['user_id'];

    // create a new playlist
    $query = "INSERT INTO playlists (playlist_name, playlist_date, user_id) VALUES (?, CURDATE(), ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ss", $playlist_name, $user_id);
    mysqli_stmt_execute($stmt);

    // get the ID of the newly created playlist
    $playlist_id = mysqli_insert_id($conn);

    // add the song to the new playlist
    $query = "INSERT INTO playlist_songs (song_id, playlist_id) VALUES (?, ?)";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ii", $song_id, $playlist_id);

    if (mysqli_stmt_execute($stmt)) {
        // return a success message
        echo "Playlist created and song added successfully!";
    } else {
        // return an error message
        echo "Error: " . mysqli_stmt_error($stmt);
    }
?>