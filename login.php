<?php
// Connect to the database
include_once('config.php');

// Check if the username and password were provided
if (isset($_POST['username']) && isset($_POST['password'])) {
    // Get the entered username and password
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Prepare and execute a SELECT statement
    $stmt = $conn->prepare('SELECT * FROM users WHERE user_name = ? AND user_password = ?');
    $stmt->bind_param('ss', $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a matching row was found
    if ($result->num_rows > 0) {
        // Start a session and store the user's information
        session_start();
        $_SESSION['user'] = $result->fetch_assoc();

        // Return success
        echo 'success';
    } else {
        // Return an error message
        echo 'Invalid username or password';
    }
}
?>