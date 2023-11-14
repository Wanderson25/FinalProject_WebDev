const playerDiv = document.getElementById("player");

const loopButton = document.getElementById("loop");
let play = document.getElementById("play");

const audio = document.getElementById("audio");
audio.src = audio_src;
audio.volume = localStorage.getItem('volume') || 1;

let is_loop = localStorage.getItem('loop');
let currStart = document.getElementById("currStart");
let currEnd = document.getElementById("currEnd");
let first_time = true;

let interval;
let lyric_interval;
let play_timeout;
let fadeInterval;

let waveform_style = true;

let title = document.getElementById("title");
title.innerHTML = song_title;

let cover = document.getElementById("cover"); 
cover.src = song_cover;

let view = document.getElementById("view_count");
view.innerHTML += song_view;

let date = document.getElementById("date");
date.innerHTML += song_date;


const seekBar = document.querySelector('.seek');
const seek_bar = createRange(seekBar, { orientation: 'horizontal', step: 0.01 }, handleSeekBarValueChange);

const volumeBar = document.querySelector('.volume');
const volume_bar = createRange(volumeBar, { orientation: 'vertical', value: 1, step: 0.2 }, handleVolumeBarValueChange);

volume_bar.setValue(localStorage.getItem('volume') || 1);



play.addEventListener("click", function() {
    music_player();
});

audio.onended = function() {
    if (!audio.loop) {
        // console.log("ended");
        play.textContent = "◁";
        clear_all_intervals();
    }
};


function handleSeekBarValueChange(value) {
    let currentTime = value * audio.duration;
    audio.currentTime = currentTime;
    special_message.innerHTML = "Seeking: " + format_time(currentTime);
}

function handleVolumeBarValueChange(value) {
    audio.volume = value;
    localStorage.setItem('volume', value);
    special_message.innerHTML = "Volume: " + value.toFixed(2);
}

function toggleLoop() {
    audio.loop = !audio.loop;
    if (audio.loop) {
        loopButton.style.backgroundColor = "lightblue";
        localStorage.setItem('loop', true);
        special_message.innerHTML = "Loop mode: ON";
    } else {
        loopButton.style.backgroundColor = "white";
        localStorage.setItem('loop', false);
        special_message.innerHTML = "Loop mode: OFF";
    }
}

function init_loop() {
    if(JSON.parse(is_loop)) {
        loopButton.style.backgroundColor = "lightblue";
        audio.loop = true;
    } else {
        loopButton.style.backgroundColor = "white";
        audio.loop = false;
    }
}

function play_button(is_play) {
    if(is_play) {
        play.textContent = "❚❚";
    } else {
        play.textContent = "▷";
    }
}


function playPause() {
    if (audio.paused) {
        clear_all_intervals();
        audio.play();
        play_button(true);
        special_message.innerHTML = "Song playing...";
    } else {
        clear_all_intervals();
        audio.pause();
        play_button(false);
        special_message.innerHTML = "Song paused";
    }
}

function updateProgress() {
    let currentTime = audio.currentTime;
    let duration = audio.duration;
    let percentage = (currentTime / duration);
    seek_bar.setValue(percentage);
    currStart.textContent = format_time(currentTime);
    currEnd.textContent = format_time(duration);

    if(lyric_mode) {
        update_lyric(lyrics);
    }
}

function clear_all_intervals() {
    clearInterval(interval);
    clearInterval(fadeInterval);
    clearTimeout(play_timeout);
}


function music_player() {
    if(first_time) {
        if(lyric_mode) {
            update_lyric(lyrics);
        } else {
            lyric_txt.textContent = "";
        }
        audioCtx = new AudioContext();
        audioSrc = audioCtx.createMediaElementSource(audio);
        analyser = audioCtx.createAnalyser();
        analyser.fftSize = 2048 * 16;

        dataArray = new Uint8Array(analyser.fftSize);
        
        frameCounter = 0;
        first_time = false;

        // Connect the MediaElementAudioSourceNode to both the first analyser and the filter
        audioSrc.connect(analyser);

        // Play the unfiltered audio
        analyser.connect(audioCtx.destination);
    }
    interval = setInterval(function() {
        updateProgress();
    }, 400);
    animate(ctx, analyser, dataArray);
}