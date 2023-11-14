<?php
$servername = "localhost";
$username = "root";
$password = "";

// Create connection
$conn = new mysqli($servername, $username, $password);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

function run_sql_file(string $sql_file_path)
{
    global $conn;

    $sql = file_get_contents($sql_file_path);
    
    // execute the SQL statement
    if (mysqli_multi_query($conn, $sql)) {
        // loop through the results
        do {
            // fetch and free the result
            if ($result = mysqli_store_result($conn)) {
                mysqli_free_result($result);
            }
            // check for more results
            if (!mysqli_more_results($conn)) {
                break;
            }
        } while (mysqli_next_result($conn));
        echo "$sql_file_path executed successfully<br>";
    } else {
        echo "Error creating table and adding entries: " . mysqli_error($conn);
    }

}

// read the SQL file to create the database
run_sql_file('./database_init.sql');
$conn = new mysqli($servername, $username, $password, 'bocchiMP3');
run_sql_file('./bocchi_the_base.sql');
run_sql_file('./bocchi_the_data.sql');
?>