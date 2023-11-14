<?php

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

print_r(extract_info("uploads\\music\\10. Kanye West - Believe What I Say.mp3", "uploads\covers"));
?>