<?php
// like.php script
include_once('config.php');
// get the parameters from the AJAX request
$song_id = $_POST['song_id'];
$action = $_POST['action'];
$user_id = $_POST['user_id'];

// update the database based on the action
if ($action == 'like') {
    // insert a new row into the user_likes table
    $stmt = $conn->prepare("INSERT INTO user_likes (user_id, song_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $user_id, $song_id);
    if ($stmt->execute()) {
        echo "Like successful";
    } else {
        echo "Like failed";
    }
} else {
    // delete a row from the user_likes table
    $stmt = $conn->prepare("DELETE FROM user_likes WHERE user_id = ? AND song_id = ?");
    $stmt->bind_param("ii", $user_id, $song_id);
    if ($stmt->execute()) {
        echo "Unlike successful";
    } else {
        echo "Unlike failed";
    }
}

// close the database connection
$conn->close();
?>