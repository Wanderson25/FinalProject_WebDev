<?php
// https://stackoverflow.com/a/54521690
setlocale(LC_CTYPE, "en_US.UTF-8");
putenv("PYTHONIOENCODING=utf-8");

// error_reporting(E_ERROR | E_PARSE);
if ($_FILES["song_url"]["error"] === UPLOAD_ERR_OK) {
    $file = $_FILES['song_url'];
    $song_title = $_POST['song_title'];
    $song_artist = $_POST['song_artist'];

    // Save the uploaded file to a temporary location
    $tmp_file = $file['tmp_name'];
    $upload_dir = "uploads/music/";
    $upload_path = $upload_dir . $file['name'];
    move_uploaded_file($tmp_file, $upload_path);

    // Extract information from the media file
    list($title, $artist, $duration, $release_date, $cover_art) = extract_info($upload_path, "uploads/covers");
    // $song_info = array($title, $artist, $duration, $release_date, $cover_art);
    if ($title === null && $song_title) {
        $title = $song_title;
    }
    if ($artist === null && $song_artist) {
        $artist = $song_artist;
    }

    $song_info = [
        'song_title' => $title,
        'song_artist' => $artist,
        'duration' => $duration,
        'song_url' => $upload_path,
        'date' => $release_date
    ];
    if ($cover_art) {
        $song_info['cover_art'] = $cover_art;
    };

    // Get song information from the MusicBrainz database
    if ($title !== null && $artist !== null) {
        $get_cover = $cover_art === null;
        $res_info = get_song_info($title, $artist, $get_cover);
        if ($res_info) {
            // Merge the extracted and retrieved information
            $song_info = array_merge($res_info, [
                'duration' => $duration,
                'song_url' => $upload_path,
            ], $song_info);
            if ($cover_art) {
                $song_info['cover_art'] = $cover_art;
            }
        }
    }
    

    header('Content-Type: application/json; charset=UTF-8');
    // https://stackoverflow.com/a/31822924
    echo json_encode($song_info, JSON_UNESCAPED_UNICODE);
} else {
    http_response_code(400);
    echo "Error uploading file: " . $_FILES["song_url"]["error"];
}


function extract_info($file, $save_dir = null) {
    require_once('getid3/getid3.php');
    // https://github.com/JamesHeinrich/getID3/releases/tag/v1.9.22
    $getID3 = new getID3;
    $fileinfo = $getID3->analyze($file);
    $title = null;
    $artist = null;
    $duration = null;
    $release_date = null;
    $cover_art = null;
    if (isset($fileinfo['tags'])) {
        if (isset($fileinfo['tags']['id3v2']['title'][0])) {
            $title = $fileinfo['tags']['id3v2']['title'][0];
        } elseif (isset($fileinfo['tags']['vorbiscomment']['title'][0])) {
            $title = $fileinfo['tags']['vorbiscomment']['title'][0];
        }
        if (isset($fileinfo['tags']['id3v2']['artist'][0])) {
            $artist = $fileinfo['tags']['id3v2']['artist'][0];
        } elseif (isset($fileinfo['tags']['vorbiscomment']['artist'][0])) {
            $artist = $fileinfo['tags']['vorbiscomment']['artist'][0];
        }
        if (isset($fileinfo['tags']['id3v2']['year'][0])) {
            $release_date = $fileinfo['tags']['id3v2']['year'][0];
        } elseif (isset($fileinfo['tags']['vorbiscomment']['date'][0])) {
            $release_date = $fileinfo['tags']['vorbiscomment']['date'][0];
        }
    }
    if (isset($fileinfo['playtime_seconds'])) {
        $duration = $fileinfo['playtime_seconds'] * 1000;
    }
    if (isset($fileinfo['id3v2']['APIC'][0]['data'])) {
        $cover_art = $fileinfo['id3v2']['APIC'][0]['data'];
        $cover_art_mime = $fileinfo['id3v2']['APIC'][0]['mime'];
        if (strlen($cover_art) <= 0) {
            $cover_art = null;
        }
    } elseif (isset($fileinfo['comments']['picture'][0]['data'])) {
        $cover_art = $fileinfo['comments']['picture'][0]['data'];
        $cover_art_mime = $fileinfo['comments']['picture'][0]['image_mime'];
        if (strlen($cover_art) <= 0) {
            $cover_art = null;
        }
    }
    $filepath = null;
    if ($save_dir && $cover_art) {
        $filename = preg_replace('/[^\p{L}\p{N}_]/u', '', $title . "_" . $artist);
    
        switch ($cover_art_mime) {
            case 'image/jpeg':
                $ext = 'jpg';
                break;
            case 'image/png':
                $ext = 'png';
                break;
            case 'image/gif':
                $ext = 'gif';
                break;
            default:
                $ext = 'jpg';
        }
        $filepath = "$save_dir/$filename.$ext";
        file_put_contents($filepath, $cover_art);
    }
    return array($title, $artist, $duration, $release_date, $filepath);
}

function download_file($url, $save_dir, $filename) {
    $data = file_get_contents($url);
    if (!file_exists($save_dir)) {
        mkdir($save_dir, 0777, true);
    }
    $filepath = "$save_dir/$filename.jpg";
    file_put_contents($filepath, $data);
    return $filepath;
}
function get_song_info($title, $artist, $get_cover = false) {
    $url = "http://musicbrainz.org/ws/2/release/?query=" . urlencode("release:$title AND artist:$artist") . "&fmt=json";
    $options = array(
        'http' => array(
            'method' => "GET",
            'header' => "User-Agent: song_info/1.0 (https://example.com)\r\n"
        )
    );
    $context = stream_context_create($options);
    $result = json_decode(file_get_contents($url, false, $context), true);
    // $result = json_decode(file_get_contents($url), true);
    if (isset($result['releases'])) {
        foreach ($result['releases'] as $i) {
            $song = array();
            $song['song_id'] = $i['id'];
            $song['song_title'] = $i['title'];
            $song['song_artist'] = $i['artist-credit'][0]['name'];
            $song['date'] = $i['date'];
            $cover_url = null;
            if ($get_cover) {
                $cover_url = "https://coverartarchive.org/release/" . $song['song_id'] . "/front";
                $response = get_headers($cover_url);
                if ($response === false) {
                    $cover_url = null;
                } else {
                    $location_header = null;
                    foreach ($response as $header) {
                        if (stripos($header, 'Location: ') === 0) {
                            $location_header = $header;
                            break;
                        }
                    }
                    if ($location_header) {
                        $cover_url = substr($location_header, strlen('Location: '));
                        // Download cover art using the download_file function
                        // Make sure to define the download_file function before using it
                        $title = $song['song_title'];
                        $artist = $song['song_artist'];
                        $cover_url = download_file($cover_url, "uploads/covers", $title . "_" . $artist);
                    } else {
                        $cover_url = null;
                    }
                }
            }
            $song['cover_art'] = $cover_url;
            return $song;
        }
    }
    return null;
}

?>