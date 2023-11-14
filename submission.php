<?php
setlocale(LC_CTYPE, "en_US.UTF-8");
putenv("PYTHONIOENCODING=utf-8");
// Connect to the database
include_once('config.php');

// Get the form data
$song_title = $_POST['song_title'];
$song_artist = $_POST['song_artist'];
$song_date = $_POST['song_date'];
$category_id = intval($_POST['category']);
$cover_url = $_POST['cover_url'];
$song_duration = $_POST['duration'];
$song_db_id = $_POST['song_id'];
$lyrics = "";
// Handle the song lyric
if (isset($_FILES['lyric_file']) && $_FILES['lyric_file']['error'] === UPLOAD_ERR_OK) {
    $lyrics = file_get_contents($_FILES['lyric_file']['tmp_name']);
}

// Handle the song file upload
if (isset($_FILES['song_url']) && $_FILES['song_url']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['song_url']['tmp_name'];
    $fileName = $_FILES['song_url']['name'];
    $fileSize = $_FILES['song_url']['size'];
    $fileType = $_FILES['song_url']['type'];
    // $fileNameCmps = explode(".", $fileName);
    // $fileExtension = strtolower(end($fileNameCmps));
    // $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
    $uploadFileDir = 'uploads/music/';
    $dest_path = $uploadFileDir . $fileName;

    // Check if the file already exists in the /upload folder
    if (file_exists('uploads/music/' . $fileName)) {
        // If the file already exists, use it instead of uploading a new file
        $song_url = 'uploads/music/' . $fileName;
    } else {
        // If the file does not exist, upload it
        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            $song_url = $dest_path;
        } else {
            // Handle upload error
            echo "<p>An error occurred while uploading the song file. Please try again.</p>";
        }
    }
}

// Handle the cover art file upload
if (isset($_FILES['cover_file']) && $_FILES['cover_file']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['cover_file']['tmp_name'];
    $fileName = $_FILES['cover_file']['name'];
    $fileSize = $_FILES['cover_file']['size'];
    $fileType = $_FILES['cover_file']['type'];
    $fileNameCmps = explode(".", $fileName);
    $fileExtension = strtolower(end($fileNameCmps));
    $newFileName = $song_title . '_' . $song_artist . '.' . $fileExtension;
    $uploadFileDir = 'uploads/covers/';
    $dest_path = $uploadFileDir . $newFileName;

    // Check if the file already exists in the /upload folder
    if (file_exists('uploads/covers/' . $fileName)) {
        // If the file already exists, use it instead of uploading a new file or using the cover URL
        $cover_url = 'uploads/covers/' . $fileName;
    } else {
        // If the file does not exist, upload it
        if(move_uploaded_file($fileTmpPath, $dest_path)) {
            // If cover art was uploaded, use it instead of the cover URL or existing file
            $cover_url = $dest_path;
        } else {
            // Handle upload error
            echo "<p>An error occurred while uploading the song file. Please try again.</p>";
        }
    }
} else if (filter_var($cover_url, FILTER_VALIDATE_URL)) {
    // If no cover file was uploaded but a cover URL was provided, download the image from the URL
    $imageData = @file_get_contents($cover_url);
    if ($imageData === false) {
        // If downloading the image fails, revert to the original $cover_url
    } else {
        $fileName = basename($cover_url);
        $uploadFileDir = 'uploads/covers/';
        $dest_path = $uploadFileDir . $fileName;
        file_put_contents($dest_path, $imageData);
        $cover_url = $dest_path;
    }
}

// Insert the song data into the database
$stmt = $conn->prepare("INSERT INTO songs (song_title, song_artist, song_duration, song_date, song_url, category_id, cover_url, song_db_id) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssississ", $song_title, $song_artist, $song_duration, $song_date, $song_url, $category_id, $cover_url, $song_db_id);
$stmt->execute();

// Get the ID of the last inserted row (the song_id)
$song_id = $conn->insert_id;

// Insert the lyric data into the database
$stmt = $conn->prepare("INSERT INTO lyrics (song_id, lyrics_txt) VALUES (?, ?)");
$stmt->bind_param("is", $song_id, $lyrics);
$stmt->execute();

$conn->close();
?>

<?php 
    

?>
<!DOCTYPE html>
<html>
<head>
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
	<title>Upload Form</title>
	<style>
		body {
            font-family: "DotGothic16", sans-serif;
            letter-spacing: 2px;
			margin: 50px auto;
            margin-top: 10px;
            margin-bottom: 10px;
			width: 70%;
			padding: 20px;
            background: repeating-linear-gradient(to left, #FFDAB9, #FF69B4, #FF7F7F, #ADD8E6, #FFDAB9);
            background-size: 400% 100%;
            animation: gradient_loop 3s linear infinite;
			/* border-radius: 10px; */
			box-shadow: 0px 0px 10px #888888;
            padding-right: 43px;
            padding-top: 1px;
            border: solid black;
		}
        @keyframes gradient_loop {
            0% {
                background-position:100% 50%
            }
            100% {
                background-position:-33% 50%
            }
        }

        button[type="button"] {
            font-size: 100%;
			padding: 10px 20px;
			background-color: #006BA6;
			color: #fff;
			border: solid black;
			cursor: pointer;
			margin-top: 20px;
            font-family: "DotGothic16", sans-serif;
            letter-spacing: 2px;
            font-weight: bold;
		}

		button[type="button"]:hover {
			background-color: #FFBC42;
            color: black;
		}

        #rainbow-text {
            font-size: 50px;
            font-weight: bold;
            margin: 0px;
            text-shadow: 1px 1px 2px black;
            text-align: center;
        }

        #rainbow-text span {
            display: inline-block;
            animation: rainbow 5s infinite linear, wave 5s infinite ease-in-out;
        }
        /* #FFDAB9, #FF69B4, #FF7F7F, #ADD8E6, #FFDAB9 */
        @keyframes rainbow {
            0% { color: #FFDAB9; }
            25% { color: #FF7F7F; }
            50% { color: #ADD8E6; }
            100% { color: #FFDAB9; }
        }

        @keyframes wave {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        .disable-select {
            -webkit-user-select: none; /* Safari */
            -moz-user-select: none; /* Firefox */
            -ms-user-select: none; /* IE10+/Edge */
            user-select: none; /* Standard */
        }
	</style>
</head>
<body>
    <p id="rainbow-text" class="disable-select">Upload success!</p>
    <button type="button" class="disable-select" onclick="window.location.href='http:Upload.php'">Go back to upload page</button>
	<h2>Song upload info: </h2>
<?php
echo "song id" . $song_id . "<br>";
echo "song title: " . $song_title . "<br>";
echo "song artist: " . $song_artist . "<br>";
echo "song date: " . $song_date . "<br>";
echo "song category id: " . $category_id . "<br>";
echo "song url: " . $cover_url . "<br>";
echo "song duration: " . $song_duration . "ms<br>";
echo "song db id: " . $song_db_id . "<br>";
echo "lyrics: ". "<br>" . nl2br($lyrics) . "<br>";
?>
    
</body>
<script>
    load_rainbow_text();
    function load_rainbow_text() {
        const text = document.querySelector("#rainbow-text");
        const delay = 0.1;
        const rainbowText = text.textContent.split("").map((char, i) => {
            if (char === " ") char = "&nbsp;";
            return `<span style="animation-delay: ${i * delay}s;">${char}</span>`;
        }).join("");
        text.innerHTML = rainbowText;
    }
</script>
</html>
