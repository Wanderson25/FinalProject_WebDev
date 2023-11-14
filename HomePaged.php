<?php 
    include_once('config.php');

    // Start a session
    session_start();

    $welcome_text = "Anon, <a href=\"HomePage.php\">login pwease?</a>";
    $user_id = -1;
    $user_name = "";
    $song_id = -1;
    $is_like = false;
    $delay = 0;

    // Check if the user is logged in
    if (isset($_SESSION['user'])) {
        $user_name = $_SESSION['user']['user_name'];
        $user_id = $_SESSION['user']['user_id'];
        $welcome_text = "Welcome back, " . $user_name . "!";
        
    }

    if (isset($_SESSION['delay'])) {
        $delay = $_SESSION['delay'];
    }

    if (isset($_GET['song']) && !empty($_GET['song'])) {
        $song_id = $_GET['song'];
    } else {
        // choose a random song
        $query_tmp = "SELECT song_id FROM songs ORDER BY RAND() LIMIT 1";
        $result = $conn->query($query_tmp);
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $song_id = $row['song_id'];
        }
    }
    if($song_id != -1) {
        $query_tmp = "SELECT * FROM songs s JOIN lyrics l ON s.song_id = l.song_id WHERE s.song_id = $song_id LIMIT 1";
        $result = $conn->query($query_tmp);
        if ($result->num_rows > 0) {
            // display the track listing name as a heading
            $row = $result->fetch_assoc();
            $lyrics_txt =  $row['lyrics_txt'];
            $song_url = $row['song_url'];
            $song_title = $row['song_title'];
            $song_artist = $row['song_artist'];
            $cover_url = $row['cover_url'];
            $song_view = $row['song_view'] + 1;
            $song_date = $row['song_date'];
            $update_query = "UPDATE songs SET song_view = song_view + 1 WHERE song_id = $song_id";
            $conn->query($update_query);

            // check if the user has already liked the item
            $query = "SELECT * FROM user_likes WHERE user_id='$user_id' AND song_id='$song_id'";
            $result = mysqli_query($conn, $query);
            if (mysqli_num_rows($result) > 0) {
                // the user has already liked the item
                $is_like = true;
            }
        } else {
            header("Location: HomePaged.php");
            exit();
        }
        if(!$cover_url) {
            $cover_url = "bocchi_load.gif";
        }
    }

    function if_command(string $command, $else_clause = null) {
        if (isset($_SESSION['user'])) {
            echo $command;
        } else if($else_clause) {
            echo $else_clause; 
        }  
    }

    function generate_playlist(string $pl_name, array $songs_names, array $songs_ids, array $songs_artists) {
        $playlist_html = htmlspecialchars($pl_name) . "<ul class=\"pl_pl\">";
        foreach ($songs_names as $index => $song_name) {
            $song_id = $songs_ids[$index];
            $playlist_html .= "<li class=\"pl_it\"><a class=\"pl_link\" href=\"HomePaged.php?song=" . urlencode($song_id) . "\">" . htmlspecialchars($song_name) . " - " . $songs_artists[$index] . "</a></li>\n";
        }
        $playlist_html .= "</ul>\n";

        return $playlist_html;
    }

    function generate_all_playlists() {
        global $conn;
        global $user_id;
        // get all playlists
        
        $query = "SELECT playlist_id, playlist_name FROM playlists WHERE user_id = " . $user_id;
        $result = mysqli_query($conn, $query);
    
        // for each playlist
        while ($row = mysqli_fetch_assoc($result)) {
            $playlist_id = $row['playlist_id'];
            $playlist_name = $row['playlist_name'];
    
            // get all songs in the playlist
            $query = "SELECT songs.song_id, songs.song_title, songs.song_artist FROM playlist_songs JOIN songs ON playlist_songs.song_id = songs.song_id WHERE playlist_songs.playlist_id = ?";
            $stmt = mysqli_prepare($conn, $query);
            mysqli_stmt_bind_param($stmt, "i", $playlist_id);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_bind_result($stmt, $song_id, $song_name, $song_artist);
    
            // build arrays of song names and song IDs
            $songs_names = array();
            $songs_ids = array();
            $songs_artists = array();
            while (mysqli_stmt_fetch($stmt)) {
                $songs_names[] = $song_name;
                $songs_ids[] = $song_id;
                $songs_artists[] = $song_artist;
            }
    
            // generate the HTML for the playlist
            $playlist_html = generate_playlist($playlist_name, $songs_names, $songs_ids, $songs_artists);
    
            // output the generated HTML
            echo $playlist_html;
        }
    }

    function generate_comments($song_id) {
        global $conn;
        $query = "SELECT u.user_name, c.comment_text, c.comment_date 
                  FROM comments c JOIN users u ON u.user_id = c.user_id 
                  WHERE c.song_id = ? ORDER BY c.comment_date DESC";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $song_id);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                generate_comment($row['user_name'], $row['comment_text'], $row['comment_date']);
            }
        }
    }

    function generate_tracklist(string $tl_name, array $tl_songs, bool $is_first=false) {
        $tl_name = htmlspecialchars($tl_name);
        $html = "";
        global $user_id;
        if($is_first && $user_id != -1) {
            $html .= "<br>";
        }
        $html .= "<button class=\"collapsible\">$tl_name</button>\n";
        $html .= "<div class=\"tl_content\"><ol class=\"tl_tl\">\n";
        foreach ($tl_songs as $song) {
            $song_id = $song['song_id'];
            $song_title = htmlspecialchars($song['song_title']);
            $song_artist = htmlspecialchars($song['song_artist']);
            $html .= "<li class=\"tl_it\"><a class=\"tl_link\" href=\"HomePaged.php?song=" . urlencode($song_id) . "\">$song_title - $song_artist</a></li>\n";
        }
        $html .= "</ol></div>\n";
        return $html;
    }

    function generate_all_tracklists() {
        global $conn;
    
        $html = '';
    
        // Generate tracklist for all songs
        $query = "SELECT song_id, song_title, song_artist FROM songs ORDER BY song_view DESC";
        $result = mysqli_query($conn, $query);
        $songs = mysqli_fetch_all($result, MYSQLI_ASSOC);
        $html .= generate_tracklist("All", $songs, true);
    
        // Generate tracklist for top 100 songs
        $top_songs = array_slice($songs, 0, 100);
        if (!empty($top_songs)) {
            $html .= generate_tracklist("Top 100", $top_songs);
        }
    
        // Generate tracklists for songs by artist
        $query = "SELECT DISTINCT song_artist FROM songs";
        $result = mysqli_query($conn, $query);
        $artists = mysqli_fetch_all($result, MYSQLI_ASSOC);
        foreach ($artists as $artist) {
            $artist_songs = array_filter($songs, function($song) use($artist) {
                return $song['song_artist'] === $artist['song_artist'];
            });
            $html .= generate_tracklist($artist['song_artist'], $artist_songs);
        }
    
        // Generate tracklists for songs by category
        $query = "SELECT song_id, song_title, song_artist, category_name FROM songs JOIN categories ON songs.category_id = categories.category_id ORDER BY category_name";
        $result = mysqli_query($conn, $query);
        $songs_by_category = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $category = $row['category_name'];
            if (!isset($songs_by_category[$category])) {
                $songs_by_category[$category] = array();
            }
            $songs_by_category[$category][] = $row;
        }
        foreach ($songs_by_category as $category => $category_songs) {
            $html .= generate_tracklist($category, $category_songs);
        }
    
        echo $html;
    }

    function generate_comment(string $name, string $content, $date) {
        echo    "<div class=\"s_cm\">
                    $name
                    <ul class=\"cm_cm\">
                    <li class=\"cm_it\">$content</li>
                    <li class=\"cm_dt\">$date</li>
                    </ul>
                </div>
        ";
    }

    function print_playlists_options($user_id) {
        global $conn;
        $html = "";
        // query to get all playlists for the current user
        $query = "SELECT * FROM playlists WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        while ($row = $result->fetch_assoc()) {
            $html .= "<option value='{$row['playlist_id']}'>{$row['playlist_name']}</option>\n";
        }

        return $html;
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <link rel="stylesheet" href="clean/rainbow_text.css">    
        <link rel="stylesheet" href="clean/common.css">    
        <link rel="stylesheet" href="clean/player.css">    
        <link rel="stylesheet" href="clean/homepage.css">    

        <script type="text/javascript" src="./clean/element_util.js"></script>
        <script type="text/javascript" src="./clean/range.js"></script>
        <script type="text/javascript" src="./clean/search.js"></script>
    </head>

    <body>
        <div class="content">
            <p id="rainbow-text" class="disable-select">Bocchi The STARRY</p>
            <div class="navbar disable-select">
                <button type="button" id="special_message">Messages will be shown here 😊</button>

                <?php
                if_command("<button type=\"button\" onclick=\"window.location.href='http:Upload.php'\">upload</button>");
                if_command(
                    "<button type=\"button\" onclick=\"window.location.href='http:logout.php'\">logout</button>",
                    "<button type=\"button\" onclick=\"window.location.href='http:HomePage.php'\">login</button>"
                );
                ?>
                
                <button type="button" onclick="window.location.href='http:HomePaged.php?random'">random</button>
            </div>
            
            <div class="twocol">
                <div class="search_div">
                    <input class="search" type="text" placeholder="bocchi za rokku" name="search">
                    <div class="search-results-dropdown"></div>
                </div>
                <p id="welcome-text" class="disable-select"><?php echo $welcome_text ?></p>
            </div>

            <div class="interface">
                <div id="playlist">
                    <button type="button" id="playlist-toggle">Playlist</button>
                    <div class="scrolla">
                    <div class="pl">
                        <?php if(isset($_SESSION['user'])) { generate_all_playlists();} else {echo "Login to see playlists";} ?>                        
                    </div>
                    <div class="tl">
                        <?php 
                            generate_all_tracklists();
                        ?>                        
                    </div>
                    </div>
                    
                </div>
                <?php require './clean/player.php'; ?>
                
                <div id="comments">
                    <button type="button" id="comments-toggle">Comments</button>
                    <div class="scrollb">
                        
                        <div class="cm">
                            <?php  if(isset($_SESSION['user'])) { ?>

                            <form action="" method="post">
                                <div>
                                    <label for="comment-input" id="comment-label">Add a comment:</label>
                                    <textarea id="comment-input" name="comment_text"></textarea>
                                </div>
                                <input type="hidden" name="user_id" value=<?php echo $user_id ?>>
                                <input type="hidden" name="song_id" value=<?php echo $song_id ?>>
                                <input type="submit" value="Submit Comment">
                            </form>

                            <?php  } ?>

                            <div class="real_cm">

                            <?php generate_comments($song_id); ?>
                            
                            </div>

                        </div>
                    </div>
                    
                    <!-- End here -->
                </div>
            </div>
            
        </div>
        <br>
    </body>

<head>
    <script type="text/javascript" src="./clean/rainbow_text.js"></script>
</head>

<script>
initSearch();
const content_div = document.querySelector(".content");
let special_message = document.getElementById("special_message");

const song_id = <?php echo $song_id ?>;
const user_id = <?php echo $user_id ?>;
let is_like = <?php echo var_export($is_like, true); ?>;
const user_name = `<?php echo $user_name ?>`;

let song_view = `<?php echo $song_view  ?>`;
let song_date = `<?php echo $song_date  ?>`;
let song_cover = `<?php echo addslashes($cover_url) ?>`;
let song_title = `<?php echo addslashes($song_title) . "<br><b>" . $song_artist . "</b>" ?>`;
let audio_src = `<?php echo addslashes($song_url) ?>`;

let lrc_string = `<?php echo addslashes($lyrics_txt) ?>`;

let playlist_options = "";
if(user_id != -1) {
    playlist_options = `<?php echo print_playlists_options($user_id); ?>`
    // console.log(playlist_options);
    include("./clean/add_playlist_modal.js");
    include("./clean/comment_form.js");
    include("./clean/like_form.js");
}

let text = document.querySelector("#rainbow-text");

load_rainbow_text(0.05, text);

</script>
    <head>
        <script type="text/javascript" src="./clean/element_util.js"></script>
        <script type="text/javascript" src="./clean/player.js"></script>
        <script type="text/javascript" src="./clean/lyrics.js"></script>
        <script type="text/javascript" src="./clean/visualizer.js"></script>
        <script type="text/javascript" src="./clean/side_burns.js"></script>

        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
        <title>Bocchi the STARRY</title>
    </head>
<script>
init_loop();
</script>

</html>