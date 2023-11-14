function calculate_song_duration(file, callback) {
    const audio_context = new AudioContext();
    const reader = new FileReader();
    reader.onload = function(event) {
        audio_context.decodeAudioData(event.target.result, function(buffer) {
            const duration = buffer.duration;
            const duration_in_milliseconds = ~~(duration * 1000);
            // console.log("Song duration: " + duration_in_milliseconds + "ms");
            callback(duration_in_milliseconds);
        });
    };
    reader.readAsArrayBuffer(file);
}
