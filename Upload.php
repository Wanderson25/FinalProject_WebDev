<?php 
    include_once('config.php');

    // Start a session
    session_start();

    // Check if the user is not logged in
    if (!isset($_SESSION['user'])) {
        // Redirect to the login page
        header('Location: HomePaged.php');
        exit;
    }

    function load_categories() {
        global $conn;
        $query = "SELECT * FROM categories c";
        $result = $conn->query($query);
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<option value=\"" . $row['category_id'] . "\">";
                echo $row['category_name'] . "</option>";
            }
        }
    }
?>
<!DOCTYPE html>
<html>
<body>
	<form action="submission.php" method="post" enctype="multipart/form-data">
        <p id="rainbow-text" class="disable-select">Bocchi the Upload</p>
        <label for="song_title" class="disable-select">Song Title:</label>
		<input type="text" id="song_title" name="song_title" required>
		<label for="song_artist" class="disable-select">Song Artist:</label>
		<input type="text" id="song_artist" name="song_artist" required>
        <div class="twocol">
            <div class="side_a">
                <label for="song_date" class="disable-select">Song Date:</label>
                <input type="date" id="song_date" name="song_date" >
                <label for="song_url" class="disable-select">Song File:</label>
                <input type="file" id="song_url" name="song_url" accept=".mp3,.wav,.flac" required>
                <label for="category" class="disable-select">Category:</label>
                <select id="category" class="disable-select" name="category" required>
                    <option value="">-- Select Category --</option>
                    <?php 
                        load_categories();
                    ?>
                </select>

                <label for="cover_file" class="disable-select">Cover Art upload:</label>
                <input type="file" id="cover_file" name="cover_file" accept=".jpg,.png,.jpeg">
                <label for="lyric_file" class="disable-select">Lyric Upload (LRC):</label>
                <input type="file" id="lyric_file" name="lyric_file" accept=".lrc">
            </div>
            <div class="side_b">
            <img class="cover-image" src="bocchi_load.gif" alt="">
            <label for="cover_url" class="disable-select" style="margin-left: 10px; margin-top: 10px; margin-bottom: 5px">Cover URL:</label>
		    <input type="text" id="cover_url" name="cover_url" style="width: 89%">
            </div>
        </div>
		

        <div class="bottom disable-select">
            <button type="submit">Upload</button>
            <button type="button" onclick="search_song_info()">Search</button>
            <input type="reset" value="Clear">
            <button type="button" onclick="window.location.href='http:HomePaged.php?random'">Go back to homepage</button>
            
        </div>
        <div class="extra disable-select">
            <div>
                <label for="duration">Duration (ms):</label>
                <input type="number" id="duration" name="duration" style="width:120px" required>
            </div>
            <div>
                <label for="song_id">MusicBrainz ID:</label>
                <input type="text" id="song_id" name="song_id" style="width:230px">
            </div>
            <div id="loading"></div>
        </div>
	</form>
</body>

<style>
    /* #FFDAB9, #FF69B4, #FF7F7F, #ADD8E6, #FFDAB9 */  
</style>
<head>
    <link rel="stylesheet" href="./clean/upload_page.css">    
    <link rel="stylesheet" href="./clean/rainbow_text.css">    
    <link rel="stylesheet" href="./clean/common.css">    
    
    <script type="text/javascript" src="./clean/rainbow_text.js"></script>
    <script type="text/javascript" src="./clean/request_util.js"></script>
    <script type="text/javascript" src="./clean/element_util.js"></script>
    <script type="text/javascript" src="./clean/audio_util.js"></script>
    <script type="text/javascript" src="./clean/upload_page.js"></script>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
	<title>Bocchi the Upload</title>
	
</head>
</html>
