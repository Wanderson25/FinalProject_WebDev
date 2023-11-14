<?php
include_once('config.php');

if (isset($_POST['comment_text'])) {
    $comment_text = $_POST['comment_text'];
    $user_id = $_POST['user_id'];
    $song_id = $_POST['song_id'];
    
    echo $user_id;
    echo $song_id;

    // prepare and bind
    $current_date = date("Y-m-d");
    $stmt = $conn->prepare("INSERT INTO comments (comment_text, comment_date, user_id, song_id) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssii", $comment_text, $current_date , $user_id, $song_id);
    // execute
    if ($stmt->execute()) {
        echo "Comment added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    // close statement and connection
    $stmt->close();
    $conn->close();
}
?>