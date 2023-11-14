<?php
// search.php
include_once('config.php');
if (isset($_GET["query"])) {
    $query = $_GET["query"];
    
    // Prepare a SELECT statement to query the database for matching songs
    $stmt = mysqli_prepare($conn, "SELECT song_id, song_title, song_artist FROM songs WHERE MATCH(song_title, song_artist) AGAINST(? IN BOOLEAN MODE)");
    
    // Add wildcard characters to the search query
    $query = $query . "*";
    
    // Bind the search query as a parameter to the SELECT statement
    mysqli_stmt_bind_param($stmt, "s", $query);
    // Execute the SELECT statement
    mysqli_stmt_execute($stmt);
    // Bind the result columns to variables
    mysqli_stmt_bind_result($stmt, $song_id, $song_title, $song_artist);
    // Fetch the results and store them in an array
    $results = array();
    while (mysqli_stmt_fetch($stmt)) {
        $results[] = array(
            "song_id" => $song_id,
            "song_title" => $song_title,
            "song_artist" => $song_artist
        );
    }
    // Close the statement and connection
    mysqli_stmt_close($stmt);
    mysqli_close($conn);
    // Encode the results as JSON and output them
    echo json_encode($results);
}
?>