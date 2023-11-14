<?php
// Connect to the database
include_once('config.php');

// Check if the email, username, and password were provided
if (isset($_POST['email']) && isset($_POST['username']) && isset($_POST['password'])) {
    // Get the entered email, username, and password
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute an INSERT statement
    $stmt = $conn->prepare('INSERT INTO users (user_email, user_name, user_password) VALUES (?, ?, ?)');
    $stmt->bind_param('sss', $email, $username, $password);
    
    if ($stmt->execute()) {
        // Return success
        echo 'success';
    } else {
        // Return an error message
        echo 'An error occurred: ' . $stmt->error;
    }
}
?>