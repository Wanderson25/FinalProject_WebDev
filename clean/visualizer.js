let canvas = document.getElementById("canvas");

let ctx = canvas.getContext("2d");

let audioCtx;
let audioSrc;
let analyser;
let cachedCanvas;
let dataArray;
let frameCounter = 0;
let updateFrequency = 4;

let animate_interval;

function animate(ctx, analyser, dataArray) {
    if(!audio.paused) {
        animate_interval = requestAnimationFrame(() => animate(ctx, analyser,
             dataArray));
        if(waveform_style) {
            analyser.fftSize = 2048 * 16;
            drawWaveform(ctx, analyser, dataArray);
        } else {
            analyser.fftSize = 2048;
            drawFrequencyBars(ctx, analyser, dataArray);

        }
    }
}

function drawWaveform(ctx, analyser, dataArray) {
    updateFrequency = 4;
    frameCounter++;
    if (frameCounter % updateFrequency === 0) {
        let bufferLength = analyser.fftSize;
        analyser.getByteTimeDomainData(dataArray);

        drawBackground(ctx);
        drawWave(ctx, bufferLength, dataArray);
    }
}

function drawFrequencyBars(ctx, analyser, dataArray) {
    updateFrequency = 2;
    frameCounter++;
    if (frameCounter % updateFrequency === 0) {
        let bufferLength = analyser.frequencyBinCount;
        analyser.getByteFrequencyData(dataArray);
        
        drawBackground(ctx);
        drawBars(ctx, bufferLength, dataArray);
    }
}

function drawBackground(ctx) {
    ctx.fillStyle = "#FFFFFF";
    ctx.fillRect(0, 0, canvas.width, canvas.height);
}

function drawWave(ctx, bufferLength, dataArray) {
    ctx.lineWidth = 2;
    ctx.strokeStyle = "#FF69B4";
    ctx.beginPath();
    let sliceWidth = canvas.width * 1.0 / (bufferLength);
    let x = 0;
    for (let i = 0; i < bufferLength; i++) {
        let v = dataArray[i] / 128.0;
        let y = v * canvas.height / 2;
        if (i === 0) {
            ctx.moveTo(x, y);
        } else {
            ctx.lineTo(x, y);
        }
        x += sliceWidth;
    }
    ctx.lineTo(canvas.width, canvas.height / 2);
    ctx.stroke();
}

function drawBars(ctx, bufferLength, dataArray) {
    let barWidth = (canvas.width / bufferLength) + 2;
    let barHeight;
    let x = 0;
    for (let i = 0; i < bufferLength; i++) {
        barHeight = dataArray[i];
        ctx.fillStyle = "#FF69B4";
        ctx.fillRect(x, canvas.height - barHeight / 1.715, barWidth, barHeight / 1.715);
        x += barWidth + 1;
    }
}

function get_waveform_name(waveform_style) {
    if(waveform_style) {
        return "Waveform";
    } else {
        return "Spectrum";
    }
}

canvas.addEventListener("click", function() {
    waveform_style = !waveform_style;
    special_message.innerHTML = get_waveform_name(waveform_style);
});
