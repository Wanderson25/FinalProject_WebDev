<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "bocchimp3";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_GET['song'])) {
    $song_id = $_GET['song'];
    $sql = "SELECT * FROM songs WHERE song_id = $song_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        echo json_encode($row);
    } else {
        echo "No songs found";
    }
} $conn->close();




?>