let lyric_txt = document.getElementById("lyrics");
let lyric_style = document.querySelector('#lyrics');

let currentLyricIndex = 0;
let cached_lyric = "";
let lastLyricUpdate = 0;
let lyric_mode = false;

lyrics = parse_lrc_to_arr(lrc_string);

if(lyrics.length > 0) {
    lyric_mode = true;
}


function update_lyric(lyrics) {
    let currentTime = audio.currentTime;
    updateCurrentLyricIndex(lyrics, currentTime);
    currentLyric = lyrics[currentLyricIndex];
    if (currentLyric.text != cached_lyric) {
        updateCachedLyric(currentLyric.text);
        updateFadeInterval();
        updateLyricContent(cached_lyric);
    }
}

function updateCurrentLyricIndex(lyrics, currentTime) {
    if (currentLyricIndex > 0 && currentTime < lyrics[currentLyricIndex].time) {
        currentLyricIndex = 0;
    }
    while (currentLyricIndex < lyrics.length - 1 && lyrics[currentLyricIndex + 1].time <= currentTime) {
        currentLyricIndex++;
    }
}

function updateCachedLyric(text) {
    cached_lyric = text;
    lyric_style.style.opacity = 1.0;
    lastLyricUpdate = new Date().getTime();
}

function updateFadeInterval() {
    if (fadeInterval) {
        clearInterval(fadeInterval);
    }
    fadeInterval = setInterval(function () {
        let currentTime = new Date().getTime();
        let timeDiff = currentTime - lastLyricUpdate;
        if (timeDiff >= 7000) {
            let opacity = lyric_style.style.opacity;
            if (opacity > 0) {
                opacity -= 0.05;
                lyric_style.style.opacity = opacity;
            }
        }
    }, 300);
}

function updateLyricContent(cached_lyric) {
    let lyric_content = cached_lyric.trim();
    console.log(lyric_content);
    if (!doesTextFit(lyric_content)) {
        let words = cached_lyric.split(' ');
        if (words.length == 1) {
            lyric_style.style.fontSize = calculateFontSize(cached_lyric, 380) + 'px';
        } else {
            lyric_style.style.fontSize = '17px';
            let lines = [''];
            let lastSpaceIndex = -1;
            for (let i = 0; i < words.length; i++) {
                let word = words[i];
                if (word.endsWith(' ')) {
                    lastSpaceIndex = lines[lines.length - 1].length;
                }
                if (!doesTextFit(lines[lines.length - 1] + word + ' ')) {
                    if (lastSpaceIndex !== -1 && lines.length < 2) {
                        lines[lines.length - 1] = lines[lines.length - 1].substring(0, lastSpaceIndex);
                        lines.push(lines[lines.length - 1].substring(lastSpaceIndex + 1));
                    }
                    lastSpaceIndex = -1;
                }
                lines[lines.length - 1] += word + ' ';
            }
            lyric_content = lines.join('<br>');
        }
    } else {
        lyric_style.style.fontSize = '23px';
    }
    lyric_txt.innerHTML = lyric_content;
}