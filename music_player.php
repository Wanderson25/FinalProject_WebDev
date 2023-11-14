<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=DotGothic16&display=swap" rel="stylesheet">
</head>

<body>

<div id="widget">
    <audio id="audio" src=""></audio>
    <div class="playing">
        <button id="play" onclick="playPause()">&#9658;</button>
        <div class="bar">
            <input type="range" id="seek" min="0" value="0" max="100">
            <div class="bar2" id="bar2"></div>
            <div class="dot"></div>
        </div>
        <div id="duration">
            <span id="currStart">0:00</span>
            <span>/</span>
            <span id="currEnd">0:00</span>
        </div>
    </div>
    
    <div class="info">
        
        <img id="cover" class="cover_art" src="">
        <div class="song_info">
            <p id="title"></p>
            <p id="rating">Rating: 5/5</p>
            <p id="date">Released: 2019-12-14</p>
        </div>
        
    </div>
    <div class="visualizer">
        <canvas id="canvas"></canvas>
        <div class="volume_bar">
            <input type="range" id="volume" min="0" max="1" step="0.01" value="1">
        </div>
    </div>
    
  </div>
 
</div>
</body>
<style>
#widget {
  width: 300px;
  height: 300px;
  border: 1px solid black;
  background: linear-gradient(to left top, #FFDAB9, #FF69B4, #FF7F7F, #ADD8E6);
}

#duration {
  font-family: 'Franklin Gothic Medium', 'Arial Narrow', Arial, sans-serif;
}

.playing {
  display: flex;
  justify-content: space-evenly;
  margin: 10px;
}

#cover {
  width: 80px;

  align-items: left;
}

.info {
  display: flex;
  justify-content: space-evenly;
  margin: 10px;
  align-items: center;
  font-family: 'DotGothic16', sans-serif;
}

/* Added some styles for the canvas element */
#canvas {
  width: 280px;
  height: 100px;
  margin: auto;
}
#canvas {
  margin: 10px auto;
  display: block;
}
#volume {
  -webkit-appearance: slider-vertical;
  writing-mode: bt-lr;
  height: 100px;
  width: 4px;
}

.visualizer {
    display: flex;
    justify-content: space-around ;
  margin: 5px;
  align-items: center;
}
</style>
<script>
let audio = document.getElementById("audio");
let play = document.getElementById("play");
let progress = document.getElementById("progress");
let title = document.getElementById("title");
let cover = document.getElementById("cover"); 
let currStart = document.getElementById("currStart");
let currEnd = document.getElementById("currEnd");
let seek = document.getElementById("seek");
let volume = document.getElementById("volume");

// Update volume based on input value
volume.addEventListener("input", function () {
  audio.volume = volume.value;
});
function playPause() {
  if (audio.paused) {
    audio.play();
    play.innerHTML = "&#10074;&#10074;";
    updateProgress();
    fetchSong();
  } else {
    audio.pause();
    play.innerHTML = "&#9658;";
    clearInterval(interval);
  }
}

function updateProgress() {
  interval = setInterval(function () {
    let currentTime = audio.currentTime;
    let duration = audio.duration;
    let percentage = (currentTime / duration) * 100;
    seek.value = percentage;
    bar2.style.width = percentage + "%";
    currStart.textContent = formatTime(currentTime);
    currEnd.textContent = formatTime(duration);
    if (percentage >= 100) {
      clearInterval(interval);
      play.innerHTML = "&#9658;";
      seek.value = 0;
      bar2.style.width = "0%";
      currStart.textContent = "0:00";
      fetchSong();
    }
let canvas = document.getElementById("canvas");
let ctx = canvas.getContext("2d");
let audioCtx = new AudioContext();
let audioSrc = audioCtx.createMediaElementSource(audio);
let analyser = audioCtx.createAnalyser();
analyser.fftSize = 256;
audioSrc.connect(analyser);
audioSrc.connect(audioCtx.destination);

function draw() {
  requestAnimationFrame(draw);
  let bufferLength = analyser.frequencyBinCount;
  let dataArray = new Uint8Array(bufferLength);
  analyser.getByteFrequencyData(dataArray);
  ctx.fillStyle = "#FFFFFF";
  ctx.fillRect(0, 0, canvas.width, canvas.height);
  ctx.fillStyle = "#FF69B4";
  let barWidth = (canvas.width / bufferLength) * 2.5;
  let barHeight;
  let x = 0;
  for (let i = 0; i < bufferLength; i++) {
    barHeight = dataArray[i] * 0.55;
    ctx.fillRect(x, canvas.height - barHeight, barWidth, barHeight);
    x += barWidth + 1;
  }
}

draw();
  }, 1000);
}
function formatTime(time) {
  let minutes = Math.floor(time / 60);
  let seconds = Math.floor(time % 60);
  if (seconds < 10) {
    seconds = "0" + seconds;
  }
  return minutes + ":" + seconds;
}

function fetchSong() {
  fetch("song.php")
    .then((response) => response.json())
    .then((data) => {
      audio.src = data.song_url;
      title.innerHTML = data.song_title + " - " + "<b>" + data.song_artist + "</b>";
      cover.src = data.cover_url; // added a new line to set the cover art source
      audio.play();
      play.innerHTML = "&#10074;&#10074;";
      updateProgress();
    });
}

// Update seek value based on current time and duration
function updateSeek() {
  let currentTime = audio.currentTime;
  let duration = audio.duration;
  let percentage = (currentTime / duration) * 100;
  seek.value = percentage;
}

// Update current time based on seek value
seek.addEventListener("input", function () {
  let percentage = seek.value;
  let currentTime = (percentage / 100) * audio.duration;
  audio.currentTime = currentTime;
});

</script>
</html>