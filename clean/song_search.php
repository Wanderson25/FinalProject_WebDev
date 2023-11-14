<?php
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
                if (isset($response[5])) {
                    $cover_url = substr($response[5], strlen('Location: '));
                    // Download cover art using the download_file function
                    // Make sure to define the download_file function before using it
                    $title = $song['song_title'];
                    $artist = $song['song_artist'];
                    $cover_url = download_file($cover_url, "covers", $title . "_" . $artist);
                }
                
            }
            $song['cover_art'] = $cover_url;
            return $song;
        }
    }
    return null;
}

print_r(get_song_info("残酷な天使のテーゼ", "高橋洋子", true));
?>